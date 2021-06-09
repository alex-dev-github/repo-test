<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Model\Dashboard\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Dashboard
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Model\Dashboard\ResourceModel
 */
class Dashboard extends AbstractDb {

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
        $this->_init('monday_dashboard_entity', 'entity_id');
    }
}
