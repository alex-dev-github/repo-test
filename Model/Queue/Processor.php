<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Queue;

use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;
use AxProd\Monday\Helper\Data;

/**
 * Class Processor
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Queue
 */
class Processor
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Json
     */
    private Json $jsonHelper;

    /**
     * Processor constructor.
     * @param Json $jsonHelper
     * @param LoggerInterface $logger
     */
    public function __construct(
        Json $jsonHelper,
        LoggerInterface $logger
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
    }

    /**
     * @param $message
     * @return bool
     */
    public function process($message) {
        $result = false;
        $this->logger->info($message);


        return true;
    }
}
