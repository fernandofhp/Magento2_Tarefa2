<?php 
namespace Fhpdev\Pintura\Controller\Index;
use Fhpdev\Pintura\Model\PinturaFactory;

class Index extends \Magento\Framework\App\Action\Action{
    protected $_Pintura;
    public function __construct(){
        parent::__construct();
        $this->_Pintura =  \Magento\Framework\App\ObjectManager::getInstance()
                                ->get('Fhpdev\Pintura\Model\PinturaFactory');
    }
	public function execute(){        
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