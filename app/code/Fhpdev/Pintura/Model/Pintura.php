<?php
namespace Fhpdev\Pintura\Model;

class Pintura extends \Magento\Framework\Model\AbstractModel 
	implements \Magento\Framework\DataObject\IdentityInterface{

    const CACHE_TAG = 'Pintura';
	protected $_cacheTag = 'Pintura';
    protected $_eventPrefix = 'Pintura';
    
    public function _construct(){
        $this->_init("Fhpdev\Pintura\Model\ResourceModel\Pintura");
    }
    public function getIdentities(){
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues(){
		$values = [];
		return $values;
	}
}
?>