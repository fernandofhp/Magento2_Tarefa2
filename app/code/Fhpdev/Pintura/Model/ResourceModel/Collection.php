<?php 
namespace Fhpdev\Pintura\Model\ResourceModel\Pintura;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection{
	public function _construct(){
        $this->_init("Fhpdev\Pintura\Model\Pintura",
            "Fhpdev\Pintura\Model\ResourceModel\Pintura");
	}
}
 ?>