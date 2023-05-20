<?php
namespace Custom\ProductGallery\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
class Productsaveafter implements ObserverInterface
{   
    protected $_productGallery;
    protected $_filesystem;
    protected $_file;

    public function __construct(
        \Custom\ProductGallery\Model\ProductGalleryFactory $_productGallery,
        \Magento\Framework\Filesystem $_filesystem,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        $this->_productGallery = $_productGallery;
        $this->_filesystem = $_filesystem;
        $this->_file = $file;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_product = $observer->getProduct();  
        $post = $observer->getController();
        $data = $post->getRequest()->getPost('product'); 
        if(isset($data['media_productgallery']) && !empty($data['media_productgallery'])){
            $image=$data['media_productgallery']['images'];
            foreach ($image as $key => $value) {

                $productgallery=$this->_productGallery->create();
                if($value['removed']==1){
                    $mediaRootDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath()."productGallery";
                        if ($this->_file->isExists($mediaRootDir . $value['file'])) {
                            $this->_file->deleteFile($mediaRootDir . $value['file']);
                        }
                    $model=$productgallery->load($value['value_id']);
                    $model->delete(); 
                }
                if($key==$value['value_id']){
                    continue;
                }
                $preparedate['value']=$value['file'];
                $preparedate['position']=$value['position'];
                $preparedate['product_id']=$_product->getID();
                $productgallery->setData($preparedate)->save();
            }

        }
    } 
}