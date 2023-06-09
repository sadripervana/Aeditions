<?php
namespace Mageplaza\LayeredNavigation\Model\Layer\Filter;

use Magento\CatalogSearch\Model\Layer\Filter\Attribute as AbstractFilter;

class Attribute extends AbstractFilter
{
    /**
     * @var \Magento\Framework\Filter\StripTags
     */
    private $tagFilter;

    protected $filterValue = true;

    protected $_moduleHelper;

    /**
     * @param \Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Layer $layer
     * @param \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder
     * @param \Magento\Framework\Filter\StripTags $tagFilter
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Model\Layer\Filter\ItemFactory $filterItemFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Layer $layer,
        \Magento\Catalog\Model\Layer\Filter\Item\DataBuilder $itemDataBuilder,
        \Magento\Framework\Filter\StripTags $tagFilter,
        \Mageplaza\LayeredNavigation\Helper\Data $moduleHelper,
        array $data = []
    ) {
        parent::__construct(
            $filterItemFactory,
            $storeManager,
            $layer,
            $itemDataBuilder,
            $tagFilter,
            $data
        );
        $this->tagFilter = $tagFilter;
        $this->_moduleHelper = $moduleHelper;
    }

    /**
     * Apply attribute option filter to product collection
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {
        if(!$this->_moduleHelper->isEnabled()){
            return parent::apply($request);
        }
        $attributeValue = $request->getParam($this->_requestVar);

        if (empty($attributeValue)) {
            $this->filterValue = false;
            return $this;
        }
        $attributeValue = explode(',', $attributeValue);
        $attribute = $this->getAttributeModel();
        /** @var \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $productCollection */
        $productCollection = $this->getLayer()
            ->getProductCollection();
        if(sizeof($attributeValue) > 1){
			$valueFilter = array();
			foreach($attributeValue as $value){
				$valueFilter[] = array('eq' => $value);
			}
			$productCollection->addFieldToFilter($attribute->getAttributeCode(), array('ln_filter' => $valueFilter));
        } else {
            $productCollection->addFieldToFilter($attribute->getAttributeCode(), $attributeValue[0]);
        }

        $state = $this->getLayer()->getState();
        foreach($attributeValue as $value){
            $label = $this->getOptionText($value);
            $state->addFilter($this->_createItem($label, $value));
        }

        return $this;
    }

    /**
     * Get data array for building attribute filter items
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getItemsData()
    {
        if(!$this->_moduleHelper->isEnabled()){
            return parent::_getItemsData();
        }

        $attribute = $this->getAttributeModel();
        /** @var \Mageplaza\LayeredNavigation\Model\ResourceModel\Fulltext\Collection $productCollection */
        $productCollection = $this->getLayer()
            ->getProductCollection();


        // if($this->filterValue){
        //     $productCollectionClone = $productCollection->getCollectionClone();
        //     $collection = $productCollectionClone->removeAttributeSearch($attribute->getAttributeCode());
        // } else {
        //     $collection = $productCollection;
        // }
        $collection = $productCollection;
        $optionsFacetedData = $collection->getFacetedData($attribute->getAttributeCode());

        if (count($optionsFacetedData) === 0
            && $this->getAttributeIsFilterable($attribute) !== static::ATTRIBUTE_OPTIONS_ONLY_WITH_RESULTS
        ) {
            return $this->itemDataBuilder->build();
        }

        $productSize = $collection->getSize();

        $options = $attribute->getFrontend()
            ->getSelectOptions();
        foreach ($options as $option) {
            if (empty($option['value'])) {
                continue;
            }

            $value = $option['value'];

            $count = isset($optionsFacetedData[$value]['count'])
                ? (int)$optionsFacetedData[$value]['count']
                : 0;
            // Check filter type
            if (
                $this->getAttributeIsFilterable($attribute) === static::ATTRIBUTE_OPTIONS_ONLY_WITH_RESULTS
                && (!$this->isOptionReducesResults($count, $productSize) || $count === 0)
            ) {
                continue;
            }
            $this->itemDataBuilder->addItemData(
                $this->tagFilter->filter($option['label']),
                $value,
                $count
            );
        }

        return $this->itemDataBuilder->build();
    }
}
