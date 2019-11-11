<?php

namespace Atniqi\ProductsWidgetSlider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class SortByBestSeller implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'name', 'label' => __('Product Name')],
            ['value' => 'price', 'label' => __('Price')],
            ['value' => 'sold_quantity', 'label' => __('Ordered Number')]
        ];
    }
}
