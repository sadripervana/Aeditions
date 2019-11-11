<?php
/**
 * Bss Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category   Bss
 * @package    Bss_ProductsWidgetSlider
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Bss Commerce Co. ( http://bsscommerce.com )
 * @license    http://bsscommerce.com/Bss-Commerce-License.txt
 */

namespace Atniqi\ProductsWidgetSlider\Block;

use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class GetData extends ProductsList
{
    const DEFAULT_WEBSITE = 0;
    const DEFAULT_SHOW_PRICE = false;
    const DEFAULT_SHOW_CART = false;
    const DEFAULT_SHOW_WISH_LIST = false;
    const DEFAULT_SHOW_COMPARE = false;
    const DEFAULT_SHOW_OUT_OF_STOCK = false;
    const DEFAULT_COLLECTION_SORT_BY = 'name';
    const DEFAULT_COLLECTION_ORDER = 'ASC';
    const DEFAULT_SHOW_AS_SLIDER = false;
    const DEFAULT_PRODUCTS_PER_SLIDE = 5;
    const DEFAULT_SHOW_NAV_BAR = true;
    const DEFAULT_SHOW_PREV_NEXT = true;
    const DEFAULT_AUTO_EVERY = 0;

    /**
     * @var bssHelper|\Bss\ProductsWidgetSlider\Helper\Data
     */
    protected $bssHelper;

    /**
     * @var \Magento\Catalog\Block\Product\ListProduct
     */
    protected $listProduct;

    /**
     * @var \Bss\ProductsWidgetSlider\Model\ResourceModel\GetStockStatus
     */
    protected $getStockStatus;

    /**
     * @var \Magento\Catalog\Helper\Output
     */
    protected $Output;

    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $postHelper;

    /**
     * @var \Magento\Wishlist\Helper\Data
     */
    protected $wishListHelper;

    /**
     * @var \Magento\Catalog\Helper\Product\Compare
     */
    protected $compareHelper;

    /**
     * @var PriceCurrency
     */
    private $priceCurrency;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrencyInterface;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

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
            $conditionsHelper,
            $data
        );
        $this->listProduct = $listProduct;
        $this->getStockStatus = $bssGetStockStatus;
        $this->bssHelper = $bssHelper;
        $this->Output = $Output;
        $this->postHelper = $postHelper;
        $this->productMetadata = $productMetadata;
        $this->wishListHelper = $context->getWishlistHelper();
        $this->compareHelper = $context->getCompareProduct();
        $this->priceCurrencyInterface = $priceCurrencyInterface;
    }


    public function getEnableConfig()
    {
        return $this->bssHelper->getEnable();
    }

    public function setCache()
    {
        return $this->setData('cache_lifetime', '0');
    }

    public function genKey()
    {
        $key = uniqid();
        return $key;
    }
    

    public function getSortBy()
    {
        if (!$this->hasData('collection_sort_by')) {
            $this->setData('collection_sort_by', self::DEFAULT_COLLECTION_SORT_BY);
        }
        return $this->getData('collection_sort_by');
    }


    public function getSortOrder()
    {
        if (!$this->hasData('collection_sort_order')) {
            $this->setData('collection_sort_order', self::DEFAULT_COLLECTION_ORDER);
        }
        return $this->getData('collection_sort_order');
    }

    public function dateRange()
    {
        $fromDate = $this->getFromDate();
        $toDate = $this->getToDate();
        $sqlQuery='';
        if ($fromDate !='' && $toDate !='') {
            if (strtotime($toDate) < strtotime($fromDate)) {
                $sqlQuery .=" AND aggregation.period BETWEEN '{$toDate}' AND '{$fromDate}'";
            } else {
                $sqlQuery .=" AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'";
            }
        }
        if ($fromDate !='' && $toDate =='') {
            $sqlQuery .=" AND aggregation.period >= '{$fromDate}'";
        }
        if ($fromDate =='' && $toDate !='') {
            $sqlQuery .=" AND aggregation.period <= '{$toDate}'";
        }
        return $sqlQuery;

    }

}
