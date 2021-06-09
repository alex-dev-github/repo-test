<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Product\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AxProd\Monday\Model\Product\Product;
use AxProd\Monday\Model\Product\ResourceModel\Product as ResourceModel;

/**
 * Class Collection
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Product\ResourceModel\Product
 */
class Collection extends AbstractCollection {
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'axprod_monday_product_collection';
    protected $_eventObject = 'monday_product_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Product::class, ResourceModel::class);
    }
}
