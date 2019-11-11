<?php

namespace Atniqi\ProductsWidgetSlider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class SortOrder implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'ASC', 'label' => __('Ascending')],
            ['value' => 'DESC', 'label' => __('Descending')]
        ];
    }
}
