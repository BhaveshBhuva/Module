<?php

namespace Custom\ProductGallery\Model\ResourceModel\ProductGallery;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'value_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Custom\ProductGallery\Model\ProductGallery',
            'Custom\ProductGallery\Model\ResourceModel\ProductGallery'
        );
    }
}