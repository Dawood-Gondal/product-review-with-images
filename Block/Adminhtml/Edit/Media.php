<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Block\Adminhtml\Edit;

use M2Commerce\ProductReviewWithImages\Model\ResourceModel\ReviewMedia\CollectionFactory as ReviewMediaFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\UrlInterface;

/**
 * Class Media
 */
class Media extends \Magento\Backend\Block\Template
{
    /**
     * @var ReviewMediaFactory
     */
    protected $reviewMediaFactory;

    /**
     * @param Context $context
     * @param ReviewMediaFactory $reviewMediaFactory
     */
    public function __construct(
        Context $context,
        ReviewMediaFactory $reviewMediaFactory
    )
    {
        $this->reviewMediaFactory = $reviewMediaFactory;
        $this->setTemplate("media.phtml");
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getMediaCollection()
    {
        return $this->reviewMediaFactory->create()
            ->addFieldToFilter('review_id', $this->getRequest()->getParam('id'));
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getReviewMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'review_images';
    }
}
