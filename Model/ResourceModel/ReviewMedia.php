<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_ProductReviewWithImages
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\ProductReviewWithImages\Model\ResourceModel;

/**
 * Class ReviewMedia
 */
class ReviewMedia extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @return void
     */
    protected function _construct() {
        $this->_init('m2c_catalog_product_review_media', 'primary_id');
    }

}
