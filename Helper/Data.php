<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Helper
 */
class Data extends AbstractHelper {
    public const DASHBOARD_PRODUCTS = [
       'code' => 'products',
       'name' => 'Products'
    ];

    public const DASHBOARD_ORDERS = [
        'code' => 'orders',
        'name' => 'Orders'
    ];

    public const DASHBOARD_CUSTOMERS = [
        'code' => 'customers',
        'name' => 'Customers'
    ];

    const SYNC_STATUS_PENDING    = 0;
    const SYNC_STATUS_SUCCESS    = 1;
    const SYNC_STATUS_ERROR      = 2;

    const ENTITY_TYPE_PRODUCT   = 'product';
    const ENTITY_TYPE_ORDER     = 'order';
    const ENTITY_TYPE_CUSTOMER  = 'customer';
}
