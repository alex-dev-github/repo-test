<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Api;

use AxProd\Monday\Api\Data\DashboardInterface;

/**
 * Interface DashboardRepositoryInterface
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Api
 */
interface DashboardRepositoryInterface
{
    /**
     * @param int $id
     * @return DashboardInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param DashboardInterface $dashboard
     * @return DashboardInterface
     */
    public function save(DashboardInterface $dashboard);

    /**
     * @param DashboardInterface $dashboard
     * @return void
     */
    public function delete(DashboardInterface $dashboard);

    /**
     * @return void
     */
    public function deleteAll();
}
