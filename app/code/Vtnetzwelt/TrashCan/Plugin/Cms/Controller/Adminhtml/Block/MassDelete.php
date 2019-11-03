<?php

/* Vtnetzweltetzwelt_TrashCan Blocks Mass Delete Controller
* @category VTN
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/

namespace Vtnetzwelt\TrashCan\Plugin\Cms\Controller\Adminhtml\Block;

use \Magento\Framework\Controller\ResultFactory;

class MassDelete
{
    protected $filter;
    protected $collectionFactory;
    protected $resultFactory;
    protected $messageManager;

    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $collectionFactory,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
    }

    public function aroundExecute(
        \Magento\Cms\Controller\Adminhtml\Block\MassDelete $subject,
        \Closure $proceed
    ) {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $blocksDeleted = 0;
        foreach ($collection->getItems() as $block) {
            $block->setIsActive(3)->save();
            ++$blocksDeleted;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been sent to trashcan.', $blocksDeleted)
        );

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
