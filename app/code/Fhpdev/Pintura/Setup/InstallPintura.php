<?php 
namespace Fhpdev\Pintura\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface{
    public function install(SchemaSetupInterface $setup,ModuleContextInterface $context){
        $setup->startSetup();
        $conn = $setup->getConnection();
        $tableName = $setup->getTable('Pintura');
        $pk_opt = ['identity'=>true,'unsigned'=>true,'nullable'=>false,'primary'=>true];
        if($conn->isTableExists($tableName) != true){
            $table = $conn->newTable($tableName)
                ->addColumn( 'id', Table::TYPE_INTEGER, null, $pk_opt )
                ->addColumn( 'cor',Table::TYPE_TEXT, 6, ['nullable'=>false,'default'=>''] )
                ->addColumn('id_loja', Table::TYPE_INTEGER, null, ['nullbale'=>true] )
                ->setOption('charset','utf8');
            $conn->createTable($table);
        }
        $setup->endSetup();
    }
}
 ?>