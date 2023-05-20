<?php

namespace Custom\ProductGallery\Block;

/**
 * ProductGallery content block
 */
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
class ProductGallery extends \Magento\Framework\View\Element\Template
{
    protected $registry;
    protected $_productgallery;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Custom\ProductGallery\Model\ProductGalleryFactory $productgallery,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Framework\Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->_productgallery = $productgallery;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->imageFactory = $imageFactory;
        $this->_filesystem = $filesystem;
        $this->_directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }
    public function getProductGalleryCollection()
    {
        $product=$this->registry->registry('current_product');
        if($product){
            $productgallery = $this->_productgallery->create();
            return $collection = $productgallery->getCollection()->addFieldToFilter('product_id',$product->getId());
        }
    }
    public function GetImageUrl($value)
    {
        return $this->getBaseMediaUrl().$value;
    }
    public function getBaseMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'productGallery';
    }
     public function getResizeImage($imageName,$width = 258,$height = 200)
    {
        /* Real path of image from directory */
        $realPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('productGallery/'.$imageName);
        $realImageName=pathinfo($realPath, PATHINFO_BASENAME);        
        if (!$this->_directory->isFile($realPath) || !$this->_directory->isExist($realPath)) {
            return false;
        }
        /* Target directory path where our resized image will be save */
        $targetDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('productGallery/resized/'.$width.'x'.$height);
        $pathTargetDir = $this->_directory->getRelativePath($targetDir);
        /* If Directory not available, create it */
        if (!$this->_directory->isExist($pathTargetDir)) {
            $this->_directory->create($pathTargetDir);
        }
        if (!$this->_directory->isExist($pathTargetDir)) {
            return false;
        }
        $image = $this->imageFactory->create();
        $image->open($realPath);
        $image->keepAspectRatio(true);
        $image->resize($width,$height);
        $dest = $targetDir . '/' . pathinfo($realPath, PATHINFO_BASENAME);
        $image->save($dest);
        if ($this->_directory->isFile($this->_directory->getRelativePath($dest))) {
            return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'productGallery/resized/'.$width.'x'.$height.'/'.$realImageName;
        }
        return false;
    } 
}
