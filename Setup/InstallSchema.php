<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Setup;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 */
class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @var File
     */
    protected $io;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @param File $io
     * @param DirectoryList $directoryList
     */
    public function __construct(
        File $io,
        DirectoryList $directoryList
    ) {
        $this->io = $io;
        $this->directoryList = $directoryList;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $this->createReviewImagesDirectory();
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('m2c_catalog_product_review_media')
        )->addColumn(
            'primary_id',
            Table::TYPE_BIGINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'primary id of this table'
        )->addColumn(
            'review_id',
            Table::TYPE_BIGINT,
            null,
            ['nullable' => false, 'unsigned' => true],
            'foreign key for review id'
        )->addColumn(
            'media_url',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'media url'
        )->addForeignKey(
            $installer->getFkName(
                'm2c_catalog_product_review_media',
                'review_id',
                'review',
                'review_id'
            ), 'review_id', $installer->getTable('review'), 'review_id', Table::ACTION_CASCADE
        );

        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function createReviewImagesDirectory()
    {
        $this->io->mkdir($this->directoryList->getPath('media') . '/review_images', 0755);
    }
}
