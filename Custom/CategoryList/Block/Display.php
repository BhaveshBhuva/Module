<?php
namespace Custom\CategoryList\Block;
use Magento\Framework\Data\Collection;
class Display extends \Magento\Framework\View\Element\Template
{
	protected $_storeManager;
	protected $categoryCollectionFactory;
	protected $categoryRepository;
	protected $request;
	public function __construct(\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Catalog\Model\CategoryRepository $categoryRepository,
		\Magento\Framework\App\RequestInterface $request,
    		\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory)
	{
		parent::__construct($context);
		$this->_storeManager = $storeManager;
		$this->categoryRepository = $categoryRepository;
		$this->request = $request;
    		$this->categoryCollectionFactory = $categoryCollectionFactory;
	}

	public function GetCategoryCollection()
	{
	$rootId = $this->_storeManager->getStore()->getRootCategoryId();
        $storeId = $this->_storeManager->getStore()->getId();
        
	$collection = $this->categoryCollectionFactory->create();
	$collection->setStoreId($storeId);
	$collection->addFieldToFilter('path', ['like' => '1/' . $rootId . '/%']);
    	$collection->addAttributeToSelect('*')->addAttributeToFilter('is_active','1')->addAttributeToFilter('level','2');
    	$collection->addFieldToFilter('children_count', array('gt' => 0));

    	$collection->addOrder('level', Collection::SORT_ORDER_ASC);
        $collection->addOrder('position', Collection::SORT_ORDER_ASC);
        $collection->addOrder('parent_id', Collection::SORT_ORDER_ASC);
        $collection->addOrder('entity_id', Collection::SORT_ORDER_ASC);
    	return $collection;

	}
	public function getChildCategory()
	{
		$categoryId=$this->request->getPostValue('id');		
		$category = $this->categoryRepository->get($categoryId);
		return $subCategories = $category->getChildrenCategories();
	}
	public function getCategory($id){
		return $this->categoryRepository->get($id);
	}
}
