<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Model;

/**
 * Class ReviewMedia
 */
class ReviewMedia extends \Magento\Framework\Model\AbstractModel
{
    /**
     * constructor
     *
     */
    protected function _construct()
    {
        $this->_init(\M2Commerce\ProductReviewWithImages\Model\ResourceModel\ReviewMedia::class);
    }
}
