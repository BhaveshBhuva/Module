<?php
namespace Custom\ProductGallery\Model\ResourceModel;

class ProductGallery extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('custom_product_gallery_additional', 'value_id');
    }
}