<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Plugin;

use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\Catalog\Api\Data\ProductInterface;
use AxProd\Monday\Model\Queue\AddPublisher;
use AxProd\Monday\Helper\Data;

/**
 * Class ProductSavePlugin
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Plugin
 */
class ProductSavePlugin
{
    /**
     * @var AddPublisher
     */
    private AddPublisher $productAddPublisher;

    /**
     * ProductSavePlugin constructor.
     * @param AddPublisher $productAddPublisher
     */
    public function __construct(AddPublisher $productAddPublisher)
    {
        $this->productAddPublisher = $productAddPublisher;
    }

    /**
     * @param ProductResource $subject
     * @param ProductResource $result
     * @param ProductInterface $product
     * @return ProductResource
     */
    public function afterSave(
        ProductResource $subject,
        ProductResource $result,
        ProductInterface $product
    ) {
        $this->productAddPublisher->execute($product->getId(), Data::ENTITY_TYPE_PRODUCT);

        return $result;
    }
}
