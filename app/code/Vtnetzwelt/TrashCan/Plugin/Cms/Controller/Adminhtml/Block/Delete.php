<?php

/* Vtnetzwelt_TrashCan Block Delete Controller
* @category VTN
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/

namespace Vtnetzwelt\TrashCan\Plugin\Cms\Controller\Adminhtml\Block;


use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Cms\Controller\Adminhtml\Block\Delete 
{
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $id = $this->getRequest()->getParam('block_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create(\Magento\Cms\Model\Block::class);
                $model->load($id);
                $model->setIsActive(3)->save();

                $this->messageManager->addSuccessMessage(__('You trashed the block.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['block_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a block to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
