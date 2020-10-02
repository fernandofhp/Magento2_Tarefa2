<?php 
namespace Fhpdev\Pintura\Controller\Index;
use Bss\Schema\Model\DataExampleFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action{
    protected $_Pintura;
    protected $resultRedirect;
    public function __construct(\Magento\Framework\App\Action\Context $context,
        \Fhpdev\Pintura\Model\DataExampleFactory  $Pintura,
            \Magento\Framework\Controller\ResultFactory $result){
        parent::__construct($context);
        $this->_Pintura = $Pintura;
        $this->resultRedirect = $result;
    }
	public function execute(){
        $resultRedirect = $this->resultRedirect->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
		$model = $this->_Pintura->create();
		$model->addData([
			"cor" => 'C1C2C3',
			"status" => true,
			"id_loja" => 1
			]);
        $saveData = $model->save();
        if($saveData){
            $this->messageManager->addSuccess( __('Insert Record Successfully !') );
        }
		return $resultRedirect;
	}
}
 ?>