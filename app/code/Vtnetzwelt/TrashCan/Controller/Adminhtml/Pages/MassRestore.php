<?php

/* Vtnetzwelt_TrashCan Blocks MassRestore Controller
* @category VTN
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/
namespace Vtnetzwelt\TrashCan\Controller\Adminhtml\Pages;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

class MassRestore extends \Magento\Backend\App\Action
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Builder $productBuilder
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $pagesRestored = 0;
        foreach ($collection->getItems() as $page) {
            $page->setIsActive(1)->save();
            $pagesRestored++;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been restored.', $pagesRestored)
        );

        $resultFactory = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultFactory->setPath('trashcan/pages/index');
    }
}
