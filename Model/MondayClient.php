<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use AxProd\Monday\Helper\Config;
use AxProd\Monday\DataProvider\QueryInterface;

/**
 * Class MondayClient
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model
 */
class MondayClient
{
    /**
     * @var Curl
     */
    private Curl $curlClient;

    /**
     * @var Json
     */
    private Json $jsonHelper;

    /**
     * @var Config
     */
    private Config $configHelper;

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * @var string
     */
    private string $token;

    /**
     * MondayClient constructor.
     * @param Curl $curlClient
     * @param Json $jsonHelper
     * @param Config $configHelper
     */
    public function __construct(
        Curl $curlClient,
        Json $jsonHelper,
        Config $configHelper
    ) {
        $this->curlClient   = $curlClient;
        $this->jsonHelper   = $jsonHelper;
        $this->configHelper = $configHelper;
        $this->apiUrl       = $this->configHelper->getApiUrl();
        $this->token        = $this->configHelper->getApiToken();
    }

    /**
     * @param QueryInterface $queryInterface
     * @return array
     * @throws \Exception
     */
    public function postQuery(QueryInterface $queryInterface) : array
    {
        $query = '';

        try {
            $query      = $queryInterface->getQuery();
            $postData   = $this->jsonHelper->serialize(['query' => $query]);

            $this->curlClient->addHeader("Content-Type", "application/json");
            $this->curlClient->addHeader("Authorization", $this->token);

            $this->curlClient->post($this->apiUrl, $postData);

            $responseBody = $this->jsonHelper->unserialize($this->curlClient->getBody());
        } catch (\Exception $e) {
            throw new \Exception('Request error. Query - ' . $query, 0, $e);
        }

        return $responseBody;
    }
}
