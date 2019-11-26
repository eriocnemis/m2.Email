<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Eriocnemis\Email\Model\Constant;

/**
 * DB install schema
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'eriocnemis_email'
         */
        $logTable = $installer->getTable('eriocnemis_email');
        if (!$installer->tableExists($logTable)) {
            $table = $installer->getConnection()->newTable(
                $logTable
            )->addColumn(
                'email_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Email Id'
            )
            ->addColumn(
                'to',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Recipient Email'
            )
            ->addColumn(
                'cc',
                Table::TYPE_TEXT,
                255,
                [],
                'Carbon Copy'
            )
            ->addColumn(
                'bcc',
                Table::TYPE_TEXT,
                255,
                [],
                'Blind Carbon Copy'
            )
            ->addColumn(
                'from',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'From'
            )
            ->addColumn(
                'reply_to',
                Table::TYPE_TEXT,
                255,
                [],
                'Reply To'
            )
            ->addColumn(
                'subject',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Subject'
            )
            ->addColumn(
                'body',
                Table::TYPE_TEXT,
                '1024k',
                ['nullable' => false],
                'Message Body'
            )
            ->addColumn(
                'error',
                Table::TYPE_TEXT,
                '64k',
                [],
                'Error'
            )
            ->addColumn(
                'dummy',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => 0],
                'Dummy Mode'
            )
            ->addColumn(
                'status',
                Table::TYPE_TEXT,
                50,
                ['nullable' => false, 'default' => Constant::STATUS_PROCESS],
                'Status'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            )
            ->addColumn(
                'duration',
                Table::TYPE_DECIMAL,
                '18,12',
                [],
                'Duration'
            )
            ->addIndex(
                $installer->getIdxName($logTable, ['to']),
                ['to']
            )
            ->addIndex(
                $installer->getIdxName($logTable, ['cc']),
                ['cc']
            )
            ->addIndex(
                $installer->getIdxName($logTable, ['bcc']),
                ['bcc']
            )
            ->addIndex(
                $installer->getIdxName($logTable, ['from']),
                ['from']
            )
            ->addIndex(
                $installer->getIdxName($logTable, ['dummy']),
                ['dummy']
            )
            ->addIndex(
                $installer->getIdxName($logTable, ['status']),
                ['status']
            )
            ->addIndex(
                $installer->getIdxName(
                    $logTable,
                    ['subject', 'body'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['subject', 'body'],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            )
            ->setComment(
                'Eriocnemis Email Log Table'
            );

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
