<?php
namespace Tougou\Icon\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
class UpgradeSchema implements UpgradeSchemaInterface{

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $this->upgrade101($setup);
        }

        if (version_compare($context->getVersion(), "1.0.2", "<")) {
            $this->upgrade102($setup);
        }

        if (version_compare($context->getVersion(), "1.0.3", "<")) {
            $this->upgrade103($setup);
        }
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    public function upgrade101(SchemaSetupInterface $setup){
        $tableName = $setup->getTable('icon');
        $setup->getConnection()->changeColumn(
            $tableName,
            'website_id',
            'site_id',
            [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => false,
                'unsigned' => true,
                'length' => 5,
                'comment' => 'Site id'
            ]
        );

        $setup->getConnection()->addColumn(
            $tableName,
            'src',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 200,
                'nullable' => true,
                'comment' => 'src'
            ]
        );

        $setup->getConnection()->changeColumn(
            $tableName,
            'comment',
            'comment',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'length' => 400,
                'comment' => 'comment'
            ]
        );

        $setup->getConnection()->changeColumn(
            $tableName,
            'bg_color',
            'bg_color',
            [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'length' => 2,
                'unsigned'=>true,
                'comment' => 'Background color'
            ]
        );
        $setup->getConnection()->changeColumn(
            $tableName,
            'color',
            'color',
            [
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'length' => 2,
                'unsigned'=>true,
                'comment' => 'color'
            ]
        );


        $setup->getConnection()->changeColumn(
            $tableName,
            'is_list',
            'is_list',
            [
                'type' => Table::TYPE_BOOLEAN,
                'nullable' => false,
                'default'=> 0,
                'comment' => 'is_list'
            ]
        );
        $setup->getConnection()->changeColumn(
            $tableName,
            'is_detail',
            'is_detail',
            [
                'type' => Table::TYPE_BOOLEAN,
                'nullable' => false,
                'default'=> 0,
                'comment' => 'is_detail'
            ]
        );

        $setup->getConnection()->changeColumn(
            $tableName,
            'seq',
            'seq',
            [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => false,
                'length' => 5,
                'unsigned'=>true,
                'comment' => 'seq'
            ]
        );

        $setup->getConnection()->addColumn(
            $tableName,
            'is_undeletable',
            [
                'type' => Table::TYPE_BOOLEAN,
                'nullable' => false,
                'default'=>0,
                'comment' => 'is_undeletable'
            ]
        );

        $setup->getConnection()->changeColumn(
            $tableName,
            'created_at',
            'created_at',
            [
                'type' => Table::TYPE_TIMESTAMP,
                'nullable' => false,
                'comment' => 'Created Timestamp'
            ]
        );
    }

    public function upgrade102(SchemaSetupInterface $setup){
        $tableName = $setup->getTable('icon');
        $connection = $setup->getConnection();
        if ($connection->tableColumnExists($tableName, 'display_name')) {
            $connection->dropColumn($tableName, 'display_name');
        }
        if ($connection->tableColumnExists($tableName, 'src')) {
            $connection->dropColumn($tableName, 'src');
        }
        if ($connection->tableColumnExists($tableName, 'site_id')) {
            $connection->changeColumn(
                $tableName,
                'site_id',
                'site_id',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'nullable' => false,
                    'unsigned' => true,
                    'length' => 5,
                    'comment' => 'Site id',
                    'after' => 'icon_id'
                ]
            );
        }
        if ($connection->tableColumnExists($tableName, 'icon')) {
            $connection->changeColumn(
                $tableName,
                'icon',
                'code',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'length' => 8,
                    'comment' => 'アイコンコード',
                ]
            );
        }

        if ($connection->tableColumnExists($tableName, 'name')) {
            $connection->changeColumn(
                $tableName,
                'name',
                'name',
                [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => false,
                    'length' => 80,
                    'comment' => 'アイコン名',
                ]
            );
        }

        if ($connection->tableColumnExists($tableName, 'bg_color')) {
            $connection->query("ALTER TABLE icon MODIFY `bg_color` TINYINT(2) NOT NULL COMMENT 'アイコンの背景色';");
        }
        if ($connection->tableColumnExists($tableName, 'color')) {
            $connection->query("ALTER TABLE icon CHANGE COLUMN `color` `font_color` TINYINT(2) NOT NULL COMMENT 'アイコンの文字色';" );
        }
        if ($connection->tableColumnExists($tableName, 'comment')) {
            $connection->query("ALTER TABLE icon MODIFY `comment` VARCHAR(400);");
        }
        if ($connection->tableColumnExists($tableName, 'updated_at')) {
            $setup->getConnection()->changeColumn(
                $tableName,
                'updated_at',
                'updated_at',
                [
                    'type' => Table::TYPE_TIMESTAMP,
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT_UPDATE,
                    'comment' => 'Updated Timestamp'
                ]
            );
        }
        if ($connection->tableColumnExists($tableName, 'upuser')) {
            $setup->getConnection()->changeColumn(
                $tableName,
                'upuser',
                'upuser_id',
                [
                    'type' => Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => false,
                    'comment' => 'Upuser ID'
                ]
            );
        }
        if ($connection->tableColumnExists($tableName, 'is_undeletable')) {
            $setup->getConnection()->changeColumn(
                $tableName,
                'is_undeletable',
                'is_undeletable',
                [
                    'type' => Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    'default'=>0,
                    'comment' => 'is_undeletable',
                    'after' => 'seq'
                ]
            );
        }
        $connection->addForeignKey(
            $setup->getFkName(
                'icon',
                'site_id',
                'store_group',
                'group_id'),
            'icon',
            'site_id',
            'store_group',
            'group_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
        );
        $connection->addForeignKey(
            $setup->getFkName(
                'icon',
                'upuser_id',
                'admin_user',
                'user_id'),
            'icon',
            'upuser_id',
            'admin_user',
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
        );
    }

    public function upgrade103(SchemaSetupInterface $setup){
        $tableName = $setup->getTable('icon');
        $connection = $setup->getConnection();
        if ($connection->tableColumnExists($tableName, 'seq')) {
            $connection->query("ALTER TABLE icon MODIFY `seq` INT(8) UNSIGNED;" );
        }
    }
}