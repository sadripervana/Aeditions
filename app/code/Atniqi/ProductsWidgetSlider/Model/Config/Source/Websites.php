<?php

namespace Atniqi\ProductsWidgetSlider\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Websites implements ArrayInterface
{
    /**
     * @var storeManager;
     */
    protected $storeManager;

    /**
     * Websites constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $storeManagerDataList = $this->storeManager->getWebsites();
        $options = [];
        $options[] = ['label' => __('All Website'), 'value' => 0];
        foreach ($storeManagerDataList as $key => $value) {
            $options[] = ['label' => __($value['name']), 'value' => $key];
        }

        return $options;
    }
}
