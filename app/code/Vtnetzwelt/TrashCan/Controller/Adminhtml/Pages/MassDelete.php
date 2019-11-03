<?php

/* Vtnetzwelt_TrashCan Blocks MassDelete Controller
* @category VTN
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/

namespace Vtnetzwelt\TrashCan\Controller\Adminhtml\Pages;

use Magento\Framework\Controller\ResultFactory;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;

    protected $collectionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $pagesDeleted = 0;
        foreach ($collection->getItems() as $page) {
            $page->delete();
            ++$pagesDeleted;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $pagesDeleted)
        );
        $resultFactory = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultFactory->setPath('trashcan/pages/index');
    }
}
