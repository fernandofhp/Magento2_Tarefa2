<?php
namespace Fhpdev\Pintura\Model;
use \Magento\Framework\Model\AbstractModel;
class Pintura extends AbstractModel{
    public function _construct(){
        $this->_init("Fhpdev\Pintura\Model\ResourceModel\Pintura");
    }
}
?>