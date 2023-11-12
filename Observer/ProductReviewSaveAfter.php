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
use Magento\MediaStorage\Model\File\UploaderFactory;

/**
 * Class ProductReviewSaveAfter
 */
class ProductReviewSaveAfter implements \Magento\Framework\Event\ObserverInterface
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
     * @var UploaderFactory
     */
    protected $fileUploaderFactory;


    /**
     * @param RequestInterface $request
     * @param Filesystem $filesystem
     * @param UploaderFactory $fileUploaderFactory
     * @param ReviewMediaFactory $reviewMediaFactory
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        RequestInterface $request,
        Filesystem $filesystem,
        UploaderFactory $fileUploaderFactory,
        ReviewMediaFactory $reviewMediaFactory
    ) {
        $this->request = $request;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->reviewMediaFactory = $reviewMediaFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $reviewId = $observer->getEvent()->getObject()->getReviewId();
        $media = $this->request->getFiles('review_media');
        $target = $this->mediaDirectory->getAbsolutePath('review_images');

        if ($media) {
            try {
                for ($i = 0; $i < count($media); $i++)
                {
                    $uploader = $this->fileUploaderFactory->create(['fileId' => 'review_media[' . $i . ']']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);

                    $result = $uploader->save($target);
                    $reviewMedia = $this->reviewMediaFactory->create();
                    $reviewMedia->setMediaUrl($result['file']);
                    $reviewMedia->setReviewId($reviewId);
                    $reviewMedia->save();
                }
            } catch (\Exception $e) {
            }
        }
    }
}
