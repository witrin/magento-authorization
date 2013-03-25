<?php 

/**
 * Controller exception that can fork different actions, cause forward or redirect
 * 
 * @category Authorization
 * @package Ionoi_Authorization
 * @author Artus Kolanowski <artus@ionoi.net>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Ionoi_Authorization_Controller_Varien_Exception extends Mage_Core_Controller_Varien_Exception
{

    /**
     * Bugfix
     * 
     * @see Mage_Core_Controller_Varien_Exception::prepareRedirect()
     */
    public function prepareRedirect($path, $arguments = array())
    {
        $this->_resultCallback = self::RESULT_REDIRECT;
        $this->_resultCallbackParams = array($path, $arguments);
        return $this;
    }
}