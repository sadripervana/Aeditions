<?php 

namespace Atniqii\Aeditions\Block;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Subcategories extends \Magento\Framework\View\Element\Template
{

	protected $_logo;
	protected $storeManager;
	protected $categoryCollection;

	public function __construct(
	    \Magento\Backend\Block\Template\Context $context,
	    \Magento\Theme\Block\Html\Header\Logo $logo,
	     StoreManagerInterface $storeManager,
	     CollectionFactory $categoryCollection,
	    array $data = []
	)
	{    
		$this->categoryCollection = $categoryCollection;
		$this->storeManager = $storeManager;   
	    $this->_logo = $logo;
	    parent::__construct($context, $data);
	}

	public function isHomePage()
	{   
	    return $this->_logo->isHomePage();
	}

	public function getMediaUrl()
	{
		return $this->storeManager
					->getStore()
					->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

	}

 	public function getCategories()
 	{
		$cats = $this->categoryCollection
					 ->create()                              
    				 ->addAttributeToSelect('*')
    				 ->setStore($this->_storeManager->getStore());

 		return $cats;

 	}


}