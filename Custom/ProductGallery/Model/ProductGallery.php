<?php
namespace Custom\ProductGallery\Model;

use Magento\Framework\Model\AbstractModel;

class ProductGallery extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Custom\ProductGallery\Model\ResourceModel\ProductGallery');
    }
}