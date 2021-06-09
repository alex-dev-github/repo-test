<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Dashboard;

use Magento\Framework\Model\AbstractModel;
use AxProd\Monday\Api\Data\DashboardInterface;

/**
 * Class Dashboard
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Dashboard
 */
class Dashboard extends AbstractModel implements DashboardInterface {
    const CACHE_TAG = 'axprod_monday_dashboard';

    protected $_cacheTag    = 'axprod_monday_dashboard';
    protected $_eventPrefix = 'axprod_monday_dashboard';

    protected function _construct()
    {
        $this->_init(ResourceModel\Dashboard::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->_getData(self::CODE);
    }

    /**
     * @return string
     */
    public function getMondayId()
    {
        return $this->_getData(self::MONDAY_ID);
    }

    /**
     * @param string $name
     * @return Dashboard
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @param string $code
     * @return Dashboard
     */
    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * @param string $mondayId
     * @return Dashboard
     */
    public function setMondayId($mondayId)
    {
        return $this->setData(self::MONDAY_ID, $mondayId);
    }

    /**
     * @return string[]
     */
    public function getIdentities() : array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
