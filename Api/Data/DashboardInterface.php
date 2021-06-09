<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Api\Data;

/**
 * Interface DashboardInterface
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Api\Data
 */
interface DashboardInterface
{
    const NAME      = 'name';
    const CODE      = 'code';
    const MONDAY_ID = 'monday_id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getMondayId();

    /**
     * @param string $mondayId
     * @return $this
     */
    public function setMondayId($mondayId);
}
