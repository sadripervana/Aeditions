<?php

namespace Atniqi\ProductsWidgetSlider\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @return mixed
     */
    public function getEnable()
    {
        return $this->scopeConfig->getValue(
            'productswidgetslider/general/enable_productswidgetslider',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
