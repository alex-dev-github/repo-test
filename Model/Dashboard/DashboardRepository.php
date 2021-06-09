<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Dashboard;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\CouldNotSaveException;
use AxProd\Monday\Api\Data\DashboardInterface;
use AxProd\Monday\Api\DashboardRepositoryInterface;
use AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard as ResourceModel;
use AxProd\Monday\Model\Dashboard\DashboardFactory as DashboardFactory;
use AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard\CollectionFactory as DashboardCollectionFactory;

/**
 * Class DashboardRepository
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Dashboard
 */
class DashboardRepository implements DashboardRepositoryInterface
{
    /**
     * @var DashboardFactory
     */
    private DashboardFactory $dashboardFactory;

    /**
     * @var DashboardCollectionFactory
     */
    private DashboardCollectionFactory $collectionFactory;

    /**
     * @var ResourceModel
     */
    private ResourceModel $resourceModel;

    /**
     * DashboardRepository constructor.
     *
     * @param DashboardFactory $dashboardFactory
     * @param DashboardCollectionFactory $collectionFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        DashboardFactory $dashboardFactory,
        DashboardCollectionFactory $collectionFactory,
        ResourceModel $resourceModel
    )
    {
        $this->dashboardFactory     = $dashboardFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->resourceModel        = $resourceModel;
    }

    /**
     * @param int $id
     * @return DashboardInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $dashboard = $this->dashboardFactory->create();

        $this->resourceModel->load($dashboard, $id);

        if (!$dashboard->getId()) {
            throw new NoSuchEntityException(__('Unable to find dashboard with ID "%1"', $id));
        }

        return $dashboard;
    }

    /**
     * @param DashboardInterface $dashboard
     * @return DashboardInterface
     * @throws CouldNotSaveException
     */
    public function save(DashboardInterface $dashboard)
    {
        try {
            $this->resourceModel->save($dashboard);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The dashboard was unable to be saved. Please try again.'),
                $e
            );
        }

        return $dashboard;
    }

    /**
     * @param DashboardInterface $dashboard
     * @return void
     * @throws StateException
     */
    public function delete(DashboardInterface $dashboard)
    {
        try {
            $this->resourceModel->delete($dashboard);
        } catch (\Exception $e) {
            throw new StateException(
                __('The "%1" dashboard couldn\'t be removed.', $dashboard->getId()),
                $e
            );
        }
    }

    /**
     * @throws StateException
     */
    public function deleteAll()
    {
        try {
            $collection = $this->collectionFactory->create();

            /** @var DashboardInterface $dashboard */
            foreach ($collection as $dashboard) {
                $this->delete($dashboard);
            }
        } catch (\Exception $e) {
            throw new StateException(
                __('Dashboards couldn\'t be removed.'),
                $e
            );
        }
    }
}
