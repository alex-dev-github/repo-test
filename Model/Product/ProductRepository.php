<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Product;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\CouldNotSaveException;
use AxProd\Monday\Api\Data\ProductInterface;
use AxProd\Monday\Api\ProductRepositoryInterface;
use AxProd\Monday\Model\Product\ResourceModel\Product as ResourceModel;
use AxProd\Monday\Model\Product\ProductFactory as ProductFactory;

/**
 * Class ProductRepository
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Product
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductFactory
     */
    private ProductFactory $productFactory;

    /**
     * @var ResourceModel
     */
    private ResourceModel $resourceModel;

    /**
     * ProductRepository constructor.
     * @param ProductFactory $productFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        ProductFactory $productFactory,
        ResourceModel $resourceModel
    )
    {
        $this->productFactory   = $productFactory;
        $this->resourceModel    = $resourceModel;
    }

    /**
     * @param int $id
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $product = $this->productFactory->create();

        $this->resourceModel->load($product, $id);

        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Unable to find monday product with ID "%1"', $id));
        }

        return $product;
    }

    /**
     * @param int $productId
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getByProductId($productId)
    {
        try {
            $id = $this->resourceModel->getIdByProductId($productId);

            if (!$id) {
                throw new NoSuchEntityException(
                    __("The product that was requested doesn't exist. Verify the product and try again.")
                );
            }

            $product = $this->productFactory->create();

            $this->resourceModel->load($product, $id);
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__($e->getMessage()), $e);
        }

        return $product;
    }

    /**
     * @param ProductInterface $product
     * @return ProductInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductInterface $product)
    {
        try {
            $this->resourceModel->save($product);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The dashboard was unable to be saved. Please try again.'),
                $e
            );
        }

        return $product;
    }

    /**
     * @param ProductInterface $product
     * @return void
     * @throws StateException
     */
    public function delete(ProductInterface $product)
    {
        try {
            $this->resourceModel->delete($product);
        } catch (\Exception $e) {
            throw new StateException(
                __('The "%1" dashboard couldn\'t be removed.', $product->getId()),
                $e
            );
        }
    }
}
