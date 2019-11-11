<?php

namespace Atniqi\ProductsWidgetSlider\Model\ResourceModel;

class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Collection
{
    /**
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectCountSql()
    {
        return $this->_getSelectCountSql()->reset(\Magento\Framework\DB\Select::GROUP);
    }
}
