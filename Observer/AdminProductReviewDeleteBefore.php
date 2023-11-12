<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Observer;

use M2Commerce\ProductReviewWithImages\Model\ResourceModel\ReviewMedia\CollectionFactory as ReviewMediaFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class AdminProductReviewDeleteBefore
 */
class AdminProductReviewDeleteBefore implements \Magento\Framework\Event\ObserverInterface
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
        // single record deletion
        $reviewId = $this->request->getParam('id', false);
        if ($reviewId) {
            $this->deleteReviewMedia($reviewId);
            return;
        }

        // mass deletion
        $reviewIds = $this->request->getParam('reviews', false);
        if ($reviewIds) {
            foreach ($reviewIds as $id) {
                $this->deleteReviewMedia($id);
            }
        }
    }

    /**
     * @param $reviewId
     * @return void
     */
    private function deleteReviewMedia($reviewId)
    {
        $target = $this->mediaDirectory->getAbsolutePath('review_images');
        try {
            $reviewMediaCollection = $this->reviewMediaFactory->create()
                ->addFieldToFilter('review_id', $reviewId);

            foreach ($reviewMediaCollection as $item)
            {
                $path = $target . $item->getMediaUrl();
                if ($this->fileHandler->isExists($path)) {
                    $this->fileHandler->deleteFile($path);
                }
            }
        } catch (\Exception $e) {
        }
    }
}
