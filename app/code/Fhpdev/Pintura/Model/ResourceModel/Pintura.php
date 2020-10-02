<?php 
    namespace Fhpdev\Pintura\Model\ResourceModel;
    
    class DataExample extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{

        public function _construct(\Magento\Framework\Model\ResourceModel\Db\Context $context){              
            parent::__construct($context); 
            $this->_init("Pintura","id");
        }

        // protected function _construct(){           
        // }
    }
 ?>