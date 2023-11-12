# M2Commerce: Magento 2 Product Review With Images

## Overview

This extension will allow your customers to upload images within default product reviews for the products they buy and can also show the unique ways they are using your products in real life. So, why not let your customers take an active part in your online eCommerce business?

### Features:

```
1. Allow your customers to upload images in Magento 2 default product reviews
2. Admin approval required to ensure relevant and appropriate images only to be viewed at frontend
3. Allows uploading of up to 10 product images
4. Allows potential customers to view the review images uploaded by other customers
5. Original image size results in good user experience
```

## Installation
### Magento® Marketplace

This extension will also be available on the Magento® Marketplace when approved.

1. Go to Magento® 2 root folder
2. Require/Download this extension:

   Enter following commands to install extension.

   ```
   composer require m2commerce/product-review-with-images"
   ```

   Wait while composer is updated.

   #### OR

   You can also download code from this repo under Magento® 2 following directory:

    ```
    app/code/M2Commerce/ProductReviewWithImages
    ```    

3. Enter following commands to enable the module:

   ```
   php bin/magento module:enable M2Commerce_ProductReviewWithImages
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:clean
   php bin/magento cache:flush
   ```

4. If Magento® is running in production mode, deploy static content:

   ```
   php bin/magento setup:static-content:deploy
   ```
