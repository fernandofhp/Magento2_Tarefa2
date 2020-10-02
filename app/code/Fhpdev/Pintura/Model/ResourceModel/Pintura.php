<?php 
    namespace Fhpdev\Pintura\Model\ResourceModel;
    use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;
    class DataExample extends AbstractDb{
        public function _construct(){
            $this->_init("Pintura","id");
        }
    }
 ?>