<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Logger\Handler;

use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class ErrorHandler
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Logger\Handler
 */
class ErrorHandler extends BaseHandler
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = MonologLogger::ERROR;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/axprod/monday/error.log';
}
