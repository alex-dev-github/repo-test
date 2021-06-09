<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Product\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Product
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Products\ResourceModel
 */
class Product extends AbstractDb {

    /**
     * Dashboard constructor.
     * @param Context $context
     */
    public function __construct(
       Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('monday_product_entity', 'entity_id');
    }

    /**
     * @param $productId
     * @return string
     * @throws LocalizedException
     */
    public function getIdByProductId($productId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from($this->getMainTable(), 'entity_id')->where('product_id = :product_id');

        $bind = [':product_id' => (int)$productId];

        return $connection->fetchOne($select, $bind);
    }
}
