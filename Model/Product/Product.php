<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Product;

use Magento\Framework\Model\AbstractModel;
use AxProd\Monday\Api\Data\ProductInterface;

/**
 * Class Product
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Product
 */
class Product extends AbstractModel implements ProductInterface {
    const CACHE_TAG = 'axprod_monday_product';

    protected $_cacheTag    = 'axprod_monday_product';
    protected $_eventPrefix = 'axprod_monday_product';

    protected function _construct()
    {
        $this->_init(ResourceModel\Product::class);
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->_getData(self::PRODUCT_ID);
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->_getData(self::SYNC_STATUS);
    }

    /**
     * @return string|null Created-at timestamp.
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @param int $productId
     * @return Product
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @param int $status
     * @return Product
     */
    public function setStatus($status)
    {
        return $this->setData(self::SYNC_STATUS, $status);
    }

    /**
     * @param string $createdAt
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
