<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AxProd\Monday\Model\Dashboard\Dashboard;
use AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard as ResourceModel;

/**
 * Class Collection
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Dashboard\ResourceModel\Dashboard
 */
class Collection extends AbstractCollection {
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'axprod_monday_dashboard_collection';
    protected $_eventObject = 'dashboard_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Dashboard::class, ResourceModel::class);
    }
}
