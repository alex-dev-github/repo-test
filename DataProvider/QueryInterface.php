<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\DataProvider;

/**
 * Interface QueryInterface
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model
 */
interface QueryInterface {
    /**
     * @return string
     */
    public function getQuery() : string;
}
