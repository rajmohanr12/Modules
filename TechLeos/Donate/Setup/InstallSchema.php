<?php
/**
 * @package     TechLeos/Donate
 * @author      code@techleos.com
 * @copyright   Copyright © Techleos. All rights reserved.
 */
declare(strict_types=1);

namespace TechLeos\Donate\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        
        $tableName = $setup->getTable('quote_item');
        $columns = [
            'donate'=> [
                'type' => Table::TYPE_INTEGER,
                'length'    => 10,
                'default' => 0,
                'nullable' => true,
                'comment' => 'Donate'
            ] 
        ];
        
        $connection = $installer->getConnection();
        foreach ($columns as $name => $definition) {
            $connection->addColumn($tableName, $name, $definition);
        }      
        $installer->endSetup();
    }
}
