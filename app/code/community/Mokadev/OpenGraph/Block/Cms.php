<?php
/**
 * MOKADEV
 *
 * @category   Mokadev
 * @package    Mokadev_Opengraph
 * @author     Mohamed Kaïd <mohamed@mokadev.com>
 */

class Mokadev_OpenGraph_Block_Cms extends Mokadev_OpenGraph_Block_Meta
{
    protected function _construct()
    {
        parent::_construct();
        if ($page = Mage::getSingleton('cms/page')) {
            //just ignore 404 cms page
            if (!$page->getId() 
                || $page->getId() == Mage::getStoreConfig('web/default/cms_no_route') ){
                return;
            }
            
            $this->setData('_site_title', $page->getTitle());
           
            if ($content = trim($page->getMetaDescription())) {
                $this->setData('_site_description', $content);                
            }
        }
        parent::_construct();
    }

}