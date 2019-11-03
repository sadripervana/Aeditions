<?php

/* Vtnetzwelt_TrashCan Block Model Collection
* @category VTN
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/

namespace Vtnetzwelt\TrashCan\Plugin\Cms\Model\ResourceModel\Block\Grid;

use Magento\Cms\Api\Data\BlockInterface;

class Collection extends \Magento\Cms\Model\ResourceModel\Block\Grid\Collection
{
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(BlockInterface::class);
        $this->joinStoreRelationTable('cms_block_store', $entityMetadata->getLinkField());
        $this->addFilter('is_active', ['neq' => 3], 'public');
    }
}
