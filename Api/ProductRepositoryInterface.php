<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Api;

use AxProd\Monday\Api\Data\ProductInterface;

/**
 * Interface ProductRepositoryInterface
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Api
 */
interface ProductRepositoryInterface
{
    /**
     * @param int $id
     * @return ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param int $productId
     * @return ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByProductId($productId);

    /**
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function save(ProductInterface $product);

    /**
     * @param ProductInterface $product
     * @return ProductInterfacevoid
     */
    public function delete(ProductInterface $product);
}
