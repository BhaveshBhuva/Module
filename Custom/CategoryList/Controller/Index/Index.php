<?php
namespace Custom\CategoryList\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Framework\App\Action\Action
{	/**
     	* @var \Magento\Framework\App\Action\Contex
     	*/
    	private $context;
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		PageFactory $resultPageFactory)
	{
		$this->_resultPageFactory = $resultPageFactory;
		$this->context           = $context;
		return parent::__construct($context);
	}

	public function execute()
	{
		$whoteData = $this->context->getRequest()->getParam('id');
		$resultPage = $this->_resultPageFactory->create();
        	$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        	$block = $resultPage->getLayout()
                ->createBlock('Custom\CategoryList\Block\Display')
                ->setTemplate('Custom_CategoryList::view.phtml')->toHtml();
                  	$resultJson->setData(['output' => $block, "suceess" => true,"ID"=>$whoteData]);
        	return $resultJson;
	}
}
