<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\ViewModel;

use M2Commerce\ProductReviewWithImages\Model\ResourceModel\ReviewMedia\CollectionFactory as ReviewMediaFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ReviewDetails
 */
class ReviewDetails implements ArgumentInterface
{
    /**
     * @var ReviewMediaFactory
     */
    protected $reviewMediaFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param ReviewMediaFactory $reviewMediaFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ReviewMediaFactory $reviewMediaFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->reviewMediaFactory = $reviewMediaFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $reviewId
     * @return mixed
     */
    public function getMediaCollection($reviewId)
    {
        return $this->reviewMediaFactory->create()
            ->addFieldToFilter('review_id', $reviewId);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getReviewMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'review_images';
    }
}
