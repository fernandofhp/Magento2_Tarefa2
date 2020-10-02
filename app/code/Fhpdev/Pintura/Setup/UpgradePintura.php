<?php 
namespace Fhpdev\Pintura\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface{
 
	public function upgrade(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $this->addStatus($setup);
        }
        $setup->endSetup();
	}
	
    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function addStatus(SchemaSetupInterface $setup) {
        $field_opts = [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            'nullable' => true,
            'default' => 1,
            'comment' => 'Status'
        ];
        $setup->getConnection()->addColumn( $setup->getTable('Pintura'), 'status', $field_opts);
    }
}
?>