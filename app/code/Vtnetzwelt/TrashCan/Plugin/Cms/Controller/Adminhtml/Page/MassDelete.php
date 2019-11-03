<?php

/* Vtnetzweltezwelt_TrashCan Pages Mass Delete Controller
* @category Vtnetzweltezwelt
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/
namespace Vtnetzwelt\TrashCan\Plugin\Cms\Controller\Adminhtml\Page;

use \Magento\Framework\Controller\ResultFactory;

class MassDelete
{
    
    protected $filter;
    protected $collectionFactory;
    protected $resultFactory;
    protected $messageManager;

    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $collectionFactory,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function aroundExecute(
        \Magento\Cms\Controller\Adminhtml\Page\MassDelete $subject,
        \Closure $proceed
    ) {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $pagesDeleted = 0;
        foreach ($collection->getItems() as $page) {
            $page->setIsActive(3)->save();
            $pagesDeleted++;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been sent to trashcan.', $pagesDeleted)
        );

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
