<?php
/**
 * MOKADEV
 *
 * @category   Mokadev
 * @package    Mokadev_OpenGraph
 * @author     Mohamed Kaïd <mohamed@mokadev.com>
 */

class Mokadev_OpenGraph_Block_Category extends Mokadev_OpenGraph_Block_Meta
{

    const CATEGORY_DESCRIPTION_ATTRIBUTE = 'meta_description';

    public function _construct()
    {
        parent::_construct();
        if ($_category = Mage::registry('current_category')) {

            $this->setData('_site_title', $_category->getMetaTitle() ? $_category->getMetaTitle() : $_category->getName());

            if ($_imgUrl = $_category->getImageUrl()) {
                $this->setData('_site_image', $_category->getImageUrl());
            }
            if ($_category->getData(self::CATEGORY_DESCRIPTION_ATTRIBUTE)) {
                $this->setData('_site_description', $_category->getData(self::CATEGORY_DESCRIPTION_ATTRIBUTE));
            } elseif ($_category->getData('description')) {
                $this->setData('_site_description', $_category->getData('description'));
            }

            $this->setData('_site_url', $_category->getUrl());
        }
    }

}