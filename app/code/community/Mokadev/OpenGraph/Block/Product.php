<?php
/**
 * MOKADEV
 *
 * @category   Mokadev
 * @package    Mokadev_OpenGraph
 * @author     Mohamed Kaïd <mohamed@mokadev.com>
 */

class Mokadev_OpenGraph_Block_Product extends Mokadev_OpenGraph_Block_Meta
{

    const PRODUCT_DESCRIPTION_ATTRIBUTE = 'meta_description';

    public function _construct()
    {
        parent::_construct();
        /* @var $_product Mage_Catalog_Model_Product */
        if ($_product = Mage::registry('current_product')) {

            $this->setData('_site_title', $_product->getName());

            if ($_product->getImage()) {

                $image = Mage::helper('catalog/image')->init(Mage::registry('current_product'), 'image')->__toString();
                $this->setData('_site_image', $image);
            }
            if ($_product->getData(self::PRODUCT_DESCRIPTION_ATTRIBUTE)) {
                $this->setData('_site_description', $_product->getData(self::PRODUCT_DESCRIPTION_ATTRIBUTE));
            } elseif ($_product->getData('short_description')) {
                $this->setData('_site_description', $_product->getData('short_description'));
            }
            $params = array('_ignore_category'=>true);
            $this->setData('_site_url', $_product->getUrlModel()->getUrl($_product, $params));
            $this->setData('_site_type', 'product');
        }
    }

}