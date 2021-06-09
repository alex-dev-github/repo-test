<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Queue;

use AxProd\Monday\Model\Queue\Processor as QueueProcessor;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\MessageQueue\MessageLockException;
use Magento\Framework\MessageQueue\ConnectionLostException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\MessageQueue\CallbackInvoker;
use Magento\Framework\MessageQueue\ConsumerConfigurationInterface;
use Magento\Framework\MessageQueue\EnvelopeInterface;
use Magento\Framework\MessageQueue\QueueInterface;
use Magento\Framework\MessageQueue\LockInterface;
use Magento\Framework\MessageQueue\MessageController;
use Magento\Framework\MessageQueue\ConsumerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AddConsumer
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Queue
 */
class AddConsumer implements ConsumerInterface
{
    /**
     * @var CallbackInvoker
     */
    private CallbackInvoker $invoker;

    /**
     * @var ResourceConnection
     */
    private ResourceConnection $resource;

    /**
     * @var ConsumerConfigurationInterface
     */
    private ConsumerConfigurationInterface $configuration;

    /**
     * @var MessageController
     */
    private MessageController $messageController;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var QueueProcessor
     */
    private QueueProcessor $queueProcessor;

    /**
     * AddConsumer constructor.
     * @param CallbackInvoker $invoker
     * @param ResourceConnection $resource
     * @param MessageController $messageController
     * @param ConsumerConfigurationInterface $configuration
     * @param LoggerInterface $logger
     * @param QueueProcessor $queueProcessor
     */
    public function __construct(
        CallbackInvoker $invoker,
        ResourceConnection $resource,
        MessageController $messageController,
        ConsumerConfigurationInterface $configuration,
        LoggerInterface $logger,
        QueueProcessor $queueProcessor
    ) {

        $this->invoker              = $invoker;
        $this->resource             = $resource;
        $this->messageController    = $messageController;
        $this->configuration        = $configuration;
        $this->logger               = $logger;
        $this->queueProcessor       = $queueProcessor;
    }

    /**
     * @param null $maxNumberOfMessages
     */
    public function process($maxNumberOfMessages = null)
    {
        $queue = $this->configuration->getQueue();
        $maxIdleTime = $this->configuration->getMaxIdleTime();
        $sleep = $this->configuration->getSleep();

        if (!isset($maxNumberOfMessages)) {
            $queue->subscribe($this->getTransactionCallback($queue));
        } else {
            $this->invoker->invoke(
                $queue,
                $maxNumberOfMessages,
                $this->getTransactionCallback($queue),
                $maxIdleTime,
                $sleep
            );
        }
    }

    /**
     * Get transaction callback. This handles the case of async.
     *
     * @param QueueInterface $queue
     * @return \Closure
     */
    private function getTransactionCallback(QueueInterface $queue)
    {
        return function (EnvelopeInterface $message) use ($queue) {
            /** @var LockInterface $lock */
            $lock = null;
            try {
                $lock = $this->messageController->lock($message, $this->configuration->getConsumerName());
                $messageBody = $message->getBody();

                $this->logger->info($messageBody);
                $result = $this->queueProcessor->process($messageBody);

                if ($result === false) {
                    $queue->reject($message);
                }
                $queue->acknowledge($message);
            } catch (MessageLockException $exception) {
                $queue->acknowledge($message);
            } catch (ConnectionLostException $e) {
                $queue->acknowledge($message);
                if ($lock) {
                    $this->resource->getConnection()
                        ->delete($this->resource->getTableName('queue_lock'), ['id = ?' => $lock->getId()]);
                }
            } catch (NotFoundException $e) {
                $queue->acknowledge($message);
                $this->logger->error($e->getMessage());
            } catch (\Exception $e) {
                $queue->reject($message, false, $e->getMessage());
                $queue->acknowledge($message);
                if ($lock) {
                    $this->resource->getConnection()
                        ->delete($this->resource->getTableName('queue_lock'), ['id = ?' => $lock->getId()]);
                }
            }
        };
    }
}
