<?php

namespace Atniqi\ProductsWidgetSlider\Model\ResourceModel;

class GetStockStatus
{
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @param $showOutOfStock
     * @return mixed
     */
    public function getStockStatus($collection, $showOutOfStock)
    {
        if ($showOutOfStock) {
            $collection->getSelect()->joinRight(
                ['stock' => $collection->getResource()->getTable('cataloginventory_stock_status')],
                'stock.product_id = e.entity_id',
                ['stock_status']
            )
                ->where("`stock`.`stock_status` = 1")
            ->orWhere("`stock`.`stock_status` = 0");
        } else {
            $collection->getSelect()->joinRight(
                ['stock' => $collection->getResource()->getTable('cataloginventory_stock_status')],
                'stock.product_id = e.entity_id',
                ['stock_status']
            )->where("`stock`.`stock_status` = 1");
        }
        return $collection;
    }
}
