<?php

namespace Atniqi\ProductsWidgetSlider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class SortByOnSale implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'name', 'label' => __('Product Name')],
            ['value' => 'final_price', 'label' => __('Price')],
            ['value' => 'fix', 'label' => __('Fix Value')],
            ['value' => 'percent', 'label' => __('%')]
        ];
    }
}
