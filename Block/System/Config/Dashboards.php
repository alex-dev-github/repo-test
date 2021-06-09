<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Dashboards
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\Block\System\Config
 */
class Dashboards extends Field
{
    /**
     * @var string
     */
    protected $_template = 'AxProd_Monday::system/config/dashboards.phtml';

    /**
     * CreateButton constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('axprod_monday/system_config_dashboard/create');
    }

    /**
     * @return string
     */
    public function getListAjaxUrl() {
        return $this->getUrl('axprod_monday/system_config_dashboard/listDashboard');
    }
}
