<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Observer;

use M2Commerce\ProductReviewWithImages\Model\ReviewMediaFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class AdminProductReviewSaveAfter
 */
class AdminProductReviewSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ReviewMediaFactory
     */
    protected $reviewMediaFactory;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var File
     */
    protected $fileHandler;

    /**
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param File $fileHandler
     * @param ReviewMediaFactory $reviewMediaFactory
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        RequestInterface $request,
        Filesystem $filesystem,
        File $fileHandler,
        ReviewMediaFactory $reviewMediaFactory
    ) {
        $this->request = $request;
        $this->fileHandler = $fileHandler;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->reviewMediaFactory = $reviewMediaFactory;
    }


    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $target = $this->mediaDirectory->getAbsolutePath('review_images');
        $deletedMediaString = $this->request->getParam('deleted_media');

        if ($deletedMediaString)
            try {
                $ids = explode(",", trim($deletedMediaString, ","));
                foreach ($ids as $id)
                {
                    $reviewMedia = $this->reviewMediaFactory->create()->load($id);
                    $path = $target . $reviewMedia->getMediaUrl();
                    if ($this->fileHandler->isExists($path)) {
                        $this->fileHandler->deleteFile($path);
                    }
                    $reviewMedia->delete();
                }
            } catch (\Exception $e) {
            }
    }
}
