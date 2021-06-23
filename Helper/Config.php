<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Helper
 */
class Config extends AbstractHelper {
    private const CONFIG_PATH_MODULE_ENABLE = 'monday/general/enable';
    private const CONFIG_PATH_API_TOKEN     = 'monday/general/api_token';

    private const ENDPOINT_URL = 'https://api.monday.com/v2'; // can be stored in config later

    /**
     * @return bool
     */
    public function isSyncEnabled() : bool {
        $a = 1;
        $a = 2;
        $b = 1;
        $b = 2;

        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_MODULE_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getApiUrl() : string {
        return self::ENDPOINT_URL;
    }

    /**
     * @return string
     */
    public function getApiToken() : string {
        return $this->scopeConfig->getValue(
            self::CONFIG_PATH_API_TOKEN,
            ScopeInterface::SCOPE_STORE
        );
    }
}
