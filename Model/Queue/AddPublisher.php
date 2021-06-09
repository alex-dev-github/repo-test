<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Queue;

use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

/**
 * Class AddPublisher
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Queue
 */
class AddPublisher
{
    const TOPIC_NAME = 'monday.sync.queue';

    /**
     * @var Json
     */
    private Json $jsonHelper;

    /**
     * @var PublisherInterface
     */
    private PublisherInterface $publisher;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * AddPublisher constructor.
     * @param PublisherInterface $publisher
     * @param Json $jsonHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        PublisherInterface $publisher,
        Json $jsonHelper,
        LoggerInterface $logger
    )
    {
        $this->publisher    = $publisher;
        $this->jsonHelper   = $jsonHelper;
        $this->logger       = $logger;
    }

    /**
     * @param $entityId
     * @param $type
     */
    public function execute($entityId, $type)
    {
        try {
            $publishData = ['entity_id' => $entityId, 'type' => $type];

            $this->publisher->publish(self::TOPIC_NAME, $this->jsonHelper->serialize($publishData));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
