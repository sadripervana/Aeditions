<?php 

namespace Atniqii\Aeditions\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;


class RelatedProducts extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;
    
    protected $categoryRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        CategoryRepositoryInterface $categoryRepository,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,        
        array $data = [] 
    )
    {    
        $this->categoryRepository = $categoryRepository;
        $this->_productCollectionFactory = $productCollectionFactory;    
        parent::__construct($context, $data);
    }
    
    public function getProductCollection()
    {
       
        return  $this->_productCollectionFactory->create();
    }


    public function getCategory($categoryId)
    {
        return $this->categoryRepository->get($categoryId);
    }
}