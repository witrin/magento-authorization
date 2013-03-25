<?php

/**
 * Configuration Source Customer Groups
 *
 * @category Authorization
 * @package Ionoi_Authorization
 * @author Artus Kolanowski <artus@ionoi.net>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Ionoi_Authorization_Model_Adminhtml_Config_Source_Customer_Redirect_Types extends Varien_Object
{
    
    public function toOptionArray()
    {
        $result = array(
            array(
                'value' => Ionoi_Authorization_Helper_Store::CUSTOM_REDIRECT,
                'label' => Mage::helper('authorization')->__('URL')
            ),
            array(
                'value' => Ionoi_Authorization_Helper_Store::PAGE_REDIRECT,
                'label' => Mage::helper('authorization')->__('Page'),
            ),
        );
        
        if (strpos($this->getPath(), 'anonymous') !== false) {
            $result[] = array(
                'value' => Ionoi_Authorization_Helper_Store::LOGIN_REDIRECT,
                'label' => Mage::helper('authorization')->__('Login'),
            );
        }
        
        return $result;
    }
}