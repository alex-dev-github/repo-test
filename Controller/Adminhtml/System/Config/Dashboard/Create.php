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
use AxProd\Monday\Model\Dashboard\DashboardFactory;
use AxProd\Monday\Api\Data\DashboardInterface;
use AxProd\Monday\Api\DashboardRepositoryInterface;
use AxProd\Monday\DataProvider\Dashboard\CreateQueryFactory;
use AxProd\Monday\Model\MondayClient;
use AxProd\Monday\Helper\Data;
use Psr\Log\LoggerInterface;

/**
 * Class Create
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Controller\Adminhtml\System\Config\Dashboard
 */
class Create extends Action
{
    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var DashboardFactory
     */
    protected DashboardFactory $dashboardFactory;

    /**
     * @var DashboardRepositoryInterface
     */
    protected DashboardRepositoryInterface $dashboardRepository;

    /**
     * @var CreateQueryFactory
     */
    protected CreateQueryFactory $createQueryFactory;

    /**
     * @var MondayClient
     */
    protected MondayClient $mondayClient;

    /**
     * Create constructor.
     * @param Context $context
     * @param DashboardFactory $dashboardFactory
     * @param DashboardRepositoryInterface $dashboardRepository
     * @param CreateQueryFactory $createQueryFactory
     * @param MondayClient $mondayClient
     * @param JsonFactory $resultJsonFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        DashboardFactory $dashboardFactory,
        DashboardRepositoryInterface $dashboardRepository,
        CreateQueryFactory $createQueryFactory,
        MondayClient $mondayClient,
        JsonFactory $resultJsonFactory,
        LoggerInterface $logger
    )
    {
        $this->dashboardFactory     = $dashboardFactory;
        $this->dashboardRepository  = $dashboardRepository;
        $this->createQueryFactory   = $createQueryFactory;
        $this->mondayClient         = $mondayClient;
        $this->resultJsonFactory    = $resultJsonFactory;
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
            $dashboardList  = [
                'b0' => Data::DASHBOARD_PRODUCTS,
                'b1' => Data::DASHBOARD_ORDERS,
                'b2' => Data::DASHBOARD_CUSTOMERS
            ];
            $names          = [];

            foreach ($dashboardList as $item) {
                $names[] = $item['name'];
            }

            $body = $this->mondayClient->postQuery(
                $this->createQueryFactory->create(['dashboards' => $names])
            );

            if (!empty($body['data'])) {
                $this->dashboardRepository->deleteAll();

                foreach ($body['data'] as $index => $board) {
                    if (!isset($dashboardList[$index])) {
                        throw new \Exception('The "%1" dashboard couldn\'t be created.', $board['name']);
                    }

                    /** @var DashboardInterface $dashboard */
                    $dashboard = $this->dashboardFactory->create();

                    $dashboard->setMondayId($board['id']);
                    $dashboard->setCode($dashboardList[$index]['code']);
                    $dashboard->setName($board['name']);

                    $this->dashboardRepository->save($dashboard);

                    $result[] = $dashboard->getData();
                }
            } else {
                throw new \Exception('Dashboards couldn\'t be created.');
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
