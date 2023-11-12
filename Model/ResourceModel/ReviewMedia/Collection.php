<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Model\ResourceModel\ReviewMedia;

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * constructor
     *
     */
    protected function _construct()
    {
        $this->_init(
            \M2Commerce\ProductReviewWithImages\Model\ReviewMedia::class,
            \M2Commerce\ProductReviewWithImages\Model\ResourceModel\ReviewMedia::class
        );
    }
}
