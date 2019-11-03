<?php

/* Vtnetzwelt_TrashCan Pages Model Collection
* @category VTN
* @package Vtnetzwelt_TrashCan
* @version 1.0.0
* @author VTNetzwelt
*/

namespace Vtnetzwelt\TrashCan\Plugin\Cms\Model\ResourceModel\Page\Grid;

use Magento\Cms\Api\Data\PageInterface;

class Collection extends \Magento\Cms\Model\ResourceModel\Page\Grid\Collection
{
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(PageInterface::class);
        $this->joinStoreRelationTable('cms_page_store', $entityMetadata->getLinkField());
        $this->addFilter('is_active', ['neq' => 3], 'public');
    }
}
