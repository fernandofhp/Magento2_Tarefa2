<?php 
namespace Fhpdev\Pintura\Model\ResourceModel\Pintura;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection{
    protected $_idFieldName = 'id';
	protected $_eventPrefix = 'pintura_collection';
    protected $_eventObject = 'pintura_collection';
    /**
	 * Define resource model
	 *
	 * @return void
	 */
    public function _construct(){
        $this->_init("Fhpdev\Pintura\Model\Pintura",
            "Fhpdev\Pintura\Model\ResourceModel\Pintura");
	}
}
 ?>