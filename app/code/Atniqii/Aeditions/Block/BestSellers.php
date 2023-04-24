<?php

namespace Atniqii\Aeditions\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class BestSellers extends \Magento\Catalog\Block\Product\ListProduct
{

    const YEARLY = "last_year_best_seller";
    const MONTHLY = "this_week_best_seller";
    const ALLTIME = "all_time_best_seller";

    protected $_collection;

    protected $categoryRepository;

    protected $_resource;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $collection,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->_collection = $collection;
        $this->_resource = $resource;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    public function getProducts()
    {
        $range = $this->getRange();


        // var_dump($this->getRange()); die;

        $count = $this->getProductCount();
        $collection = clone $this->_collection;
        $collection->addAttributeToSelect('*');

        switch($range){
            case 'yearly':
                $collection->addAttributeToFilter(self::YEARLY, 1);
            break;
            case 'monthly':
                $collection->addAttributeToFilter(self::MONTHLY, 1);
            break;
            default:
                $collection->addAttributeToFilter(self::ALLTIME, 1);
        }

        // var_dump($collection->getLastItem()->getData()); echo "<br>";
        // $collection->addFieldToFilter('id',true);
        // var_dump(count($collection));
        // echo "<br>";
        // var_dump(get_class_methods($collection)); die;
        return $collection;
    }
    public function getRange()
    {
        return $this->getData('range');
    }
    public function getLoadedProductCollection()
    {
        return $this->getProducts();
    }

    public function getProductCount()
    {
        $limit = $this->getData("product_count");
        if (!$limit)
            $limit = 10;
        return $limit;
    }
}
