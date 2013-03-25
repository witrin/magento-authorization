<?php

/**
 * Configuration Source Customer Groups
 *
 * @category Authorization
 * @package Ionoi_Authorization
 * @author Artus Kolanowski <artus@ionoi.net>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Ionoi_Authorization_Model_Adminhtml_Config_Source_Customer_Groups
{
    
    public function toOptionArray()
    {
        $groups = Mage::getResourceModel('customer/group_collection')
            ->loadData()
            ->toOptionArray();
        return $groups;
    }
}