<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Controller\Adminhtml\System\Config\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;
use AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard\CollectionFactory as DashboardCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Class ListDashboard
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Controller\Adminhtml\System\Config\Dashboard
 */
class ListDashboard extends Action
{
    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * @var DashboardCollectionFactory
     */
    protected DashboardCollectionFactory $collectionFactory;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * ListDashboard constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param DashboardCollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        DashboardCollectionFactory $collectionFactory,
        LoggerInterface $logger
    )
    {
        $this->resultJsonFactory    = $resultJsonFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->logger               = $logger;

        parent::__construct($context);
    }

    /**
     * @return Json
     */
    public function execute() : Json
    {
        $result = [];

        /** @var Json $result */
        $jsonResult = $this->resultJsonFactory->create();

        try {
            /** @var \AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard\Collection $collection */
            $collection = $this->collectionFactory->create();

            if ($collection->count()) {
                /** @var \AxProd\Monday\Model\Dashboard\Dashboard $dashboard */
                foreach ($collection as $dashboard) {
                    $result[] = $dashboard->getData();
                }
            }
        } catch (\Exception $e) {
            $this->logger->error($e);

            return $jsonResult->setData(['success' => false]);
        }

        return $jsonResult->setData(['success' => true, 'dashboards' => $result]);
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AxProd_Monday::monday_config');
    }
}
