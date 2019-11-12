<?php

namespace Atniqi\ProductsWidgetSlider\Block\Product;

use Atniqi\ProductsWidgetSlider\Model\ResourceModel\BestSellerProduct\GetBestSellerCollection;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class BestSeller extends \Atniqi\ProductsWidgetSlider\Block\GetData
{
    /**
     * @var GetBestSellerCollection
     */
    protected $getBestSellerCollection;


    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder,
        \Magento\CatalogWidget\Model\Rule $rule,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Magento\Widget\Helper\Conditions $conditionsHelper,
        \Atniqi\ProductsWidgetSlider\Model\ResourceModel\GetStockStatus $bssGetStockStatus,
        \Atniqi\ProductsWidgetSlider\Helper\Data $bssHelper,
        \Magento\Catalog\Helper\Output $Output,
        \Magento\Framework\Data\Helper\PostHelper $postHelper,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        GetBestSellerCollection $bssGetBestSellerCollection,
        priceCurrencyInterface $priceCurrencyInterface,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $listProduct,
            $conditionsHelper,
            $bssGetStockStatus,
            $bssHelper,
            $Output,
            $postHelper,
            $productMetadata,
            $priceCurrencyInterface,
            $data
        );
        $this->getBestSellerCollection = $bssGetBestSellerCollection;
    }


    public function createCollection()
    {
        $this->setCache();
        
        $dateRange = $this->getDateRange();
        
        $order = $this->getSortOrder();

        $sortBy = $this->getSortBy();

        $collection = $this->productCollectionFactory->create();

        $bestSellerCollection = $this->productCollectionFactory->create();

        $collection->setFlag('has_stock_status_filter', true);

        $collection = $this->getBestSellerCollection
                           ->getBestSellerCollection($dateRange, 0, $collection, $bestSellerCollection);

        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        $collection->getSelectCountSql($collection, false);

        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addAttributeToSelect('*')
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1));

        if ($sortBy=="name") {
            $collection = $this->_addProductAttributesAndPrices($collection)->addAttributeToSort('name', $order);
        } else {
            $collection->getSelect()->order($sortBy.' '.$order);
        }

        return $collection;
    }


   



}
