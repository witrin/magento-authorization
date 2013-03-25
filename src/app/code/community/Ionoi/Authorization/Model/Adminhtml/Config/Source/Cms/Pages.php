<?php

/**
 * Configuration Source CMS Pages
 *
 * @category Authorization
 * @package Ionoi_Authorization
 * @author Artus Kolanowski <artus@ionoi.net>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Ionoi_Authorization_Model_Adminhtml_Config_Source_Cms_Pages
{
    
    public function toOptionArray()
    {
        $groups = Mage::getResourceModel('cms/page_collection')
            ->loadData()
            ->toOptionIdArray();
        return $groups;
    }
}