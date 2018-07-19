<?php

namespace Tougou\Icon\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;
        $installer->startSetup();
        
        if (!$installer->tableExists('icon')) {
            $table = $installer->getConnection()
                    ->newTable($installer->getTable('icon'))
                    ->addColumn(
                        'icon_id',
                        Table::TYPE_INTEGER,
                        10,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'unsigned' => true,
                            'primary' => true
                        ],
                        '論理名'
                    )
                    ->addColumn(
                        'icon',
                        Table::TYPE_TEXT,
                        8,
                        ['nullable' => false],
                        'アイコン'
                    )
                    ->addColumn(
                        'name',
                        Table::TYPE_TEXT,
                        80,
                        array(),
                        'アイコン名'
                    )
                    ->addColumn(
                        'website_id',
                        Table::TYPE_INTEGER,
                        10,
                        ['unsigned' => true]
                    )
                    ->addColumn(
                        'bg_color',
                        Table::TYPE_TEXT,
                        200
                    )
                    ->addColumn(
                        'color',
                        Table::TYPE_TEXT,
                        200
                    )
                    ->addColumn(
                        'comment',
                        Table::TYPE_TEXT,
                        400
                    )
                    ->addColumn(
                        'is_list',
                        Table::TYPE_BOOLEAN
                    )
                    ->addColumn(
                        'is_detail',
                        Table::TYPE_BOOLEAN
                    )
                    ->addColumn(
                        'seq',
                        Table::TYPE_INTEGER,
                        10,
                        ['unsigned' => true]
                    )
                    ->addColumn(
                        'created_at',
                        Table::TYPE_TIMESTAMP,
                        ['nullable' => false]
                    )
                    ->addColumn(
                        'updated_at',
                        Table::TYPE_TIMESTAMP
                    )
                    ->addColumn(
                        'upuser',
                        Table::TYPE_INTEGER,
                        10,
                        ['unsigned' => true]
                    )
                    ->setComment('アイコンマスタ')
                    ->setOption('type', 'InnoDB')
                    ->setOption('charset', 'utf8')
                    ->addIndex(
                        'icon',    // index name
                        [
                            'icon',
                            'name',
                        ],
                        ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
                    );
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
