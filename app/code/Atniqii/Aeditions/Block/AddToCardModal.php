<?php 

namespace Atniqii\Aeditions\Block;

use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;

class AddToCardModal extends \Magento\Framework\View\Element\Template
{

	protected $cart;
    
    protected $product;

    protected $registry;

    protected $checkoutSession;

	public function __construct(
		\Magento\Checkout\Model\Cart $cart,
	    \Magento\Checkout\Model\Session $checkoutSession,
	    \Magento\Framework\View\Element\Template\Context $context,

		Registry $registry,
	    array $data = []
	)
	{
    	$this->cart = $cart;
        $this->registry = $registry;
        $this->checkoutSession = $checkoutSession;

	    parent::__construct($context, $data);
	}


	public function getCartItems()
	{
		return $this->cart;
 
	}

  	public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function getQuoteData()
    {
        $this->checkoutSession->getQuote();
        if (!$this->hasData('quote')) {
            $this->setData('quote', $this->checkoutSession->getQuote());
        }
        return $this->_getData('quote');
    }

	
}