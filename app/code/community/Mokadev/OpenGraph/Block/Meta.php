<?php
/**
 * MOKADEV
 *
 * @category   Mokadev
 * @package    Mokadev_Opengraph
 * @author     Mohamed Kaïd <mohamed@mokadev.com>
 */

class Mokadev_OpenGraph_Block_Meta extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        $this->setTemplate('mokadev/opengraph/og.phtml');
        parent::_construct();
    }
    /**
     *  App id
     * @return string
     */
    public function getAppId()
    {
        return Mage::getStoreConfig('general/opengraph/appid');
    }

    /**
     *  Admin App id
     * @return string
     */
    public function getAppAdminId()
    {
        return Mage::getStoreConfig('general/opengraph/adminid');
    }

    /**
     *  Nom du site
     * @return string
     */
    public function getSiteName()
    {
        if (!$this->getData('_site_name')) {
            if (!Mage::getStoreConfig('general/opengraph/sitename')) {
                $this->setData('_site_name', Mage::app()->getStore()->getName());
            } else {
                $this->setData('_site_name', Mage::getStoreConfig('general/opengraph/sitename'));
            }
        }

        return $this->_clean($this->getData('_site_name'));
    }

    /**
     *  titre du site ou du contentu
     * @return string
     */
    public function getTitle()
    {
        if (!$this->getData('_site_title')) {
            if (!Mage::getStoreConfig('general/opengraph/sitetitle')) {
                $this->setData('_site_title', Mage::getStoreConfig('design/head/default_title'));
            } else {
                $this->setData('_site_title', Mage::getStoreConfig('general/opengraph/sitetitle'));
            }
        }

        return $this->_clean($this->getData('_site_title'));
    }

    /**
     *  image du site ou liée au contentu
     * @return string
     */
    public function getImage()
    {
        if (!$this->getData('_site_image')) {
            if (!Mage::getStoreConfig('general/opengraph/image')) {
                return '';
            } else {
                $this->setData('_site_image', Mage::getStoreConfig('general/opengraph/image'));
            }
        }

        return $this->_clean($this->getData('_site_image'));
    }

    /**
     *  description du site ou du contentu
     * @return string
     */
    public function getDescription()
    {
        if (!$this->getData('_site_description')) {
            if (!Mage::getStoreConfig('general/opengraph/description')) {
                $this->setData('_site_description', Mage::getStoreConfig('design/head/default_description'));
            } else {
                $this->setData('_site_description', Mage::getStoreConfig('general/opengraph/description'));
            }
        }

        $processor = Mage::getModel('cms/template_filter');
        $html = $processor->filter($this->getData('_site_description'));
        $substrHelper = new Mokadev_OpenGraph_Helper_String(array('input' => $html, 'allowedTags' => array()));
        $content = $substrHelper->getHtmlSubstr(400);

        return $this->_clean($content);
    }

    /**
     * get current url without parameter
     * @return string
     */
    public function getOgUrl()
    {
        if (!$this->getData('_site_url')) {
            if ($_category = Mage::registry('current_category')) {
                $this->setData('_site_url', $_category->getUrl());
            } else {
                //get current url
                $url = $this->getUrl('*/*/*', array('_current' => false, '_use_rewrite' => true));
                $this->setData('_site_url', $url);
            }
        }

        return $this->getData('_site_url');
    }

    /**
     * Type de contenu (website par défaut)
     * @return string
     */
    public function getType()
    {
        if (!$this->getData('_site_type')) {
           $this->setData('_site_type', 'website');
        }

        return $this->_clean($this->getData('_site_type')); 
    }
    
    /**
     * nettoyage des contenu
     * 
     * @param string $meta
     * @return string
     * @todo something better?
     */
    protected function _clean($meta)
    {
        $meta = $this->stripTags($meta);
        $meta = htmlspecialchars(html_entity_decode(trim($meta), ENT_QUOTES, 'UTF-8'));
        
        return $meta;
    }

    /**
     * Render OpenGraph Meta
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::getStoreConfig('general/opengraph/is_active')) {
            return '';
        }

        return parent::_toHtml();
    }

}