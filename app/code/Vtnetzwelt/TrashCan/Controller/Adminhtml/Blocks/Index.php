<?php

/* Vtnetzwelt_TrashCan Blocks Index Controller
* @category VTNETZWELT
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/

namespace Vtnetzwelt\TrashCan\Controller\Adminhtml\Blocks;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(__('Manage Trashcan'), __('Manage Trashcan'));
        $resultPage->getConfig()->getTitle()->prepend(__('CMS Blocks Trashcan'));

        return $resultPage;
    }
}
