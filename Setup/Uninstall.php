<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Uninstall schema
 */
class Uninstall implements UninstallInterface
{
    /**
     * Uninstall DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        /**
         * Remove table 'eriocnemis_email'
         */
        $tableName = 'eriocnemis_email';
        if ($installer->tableExists($tableName)) {
            $connection->dropTable($installer->getTable($tableName));
        }
        $installer->endSetup();
    }
}
