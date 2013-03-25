<?php

/**
 * Authorization Observer
 * 
 * @category Authorization
 * @package Ionoi_Authorization
 * @author Artus Kolanowski <artus@ionoi.net>
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Ionoi_Authorization_Model_Observer
{
    
    public function __construct()
    {
    }
    
    /**
     * Called before action dispatched
     * 
     * @param Varien_Event_Observer $observer
     * @return Ionoi_Authorization_Model_Observer
     */
    public function onFrontendActionDispatch($observer)
    {
        if (!Mage::helper('authorization/store')->isActive()) {
            return $this;
        }
        
        /* @var $action Mage_Core_Controller_Varien_Action */
        $action = $observer->getEvent()->getControllerAction();
        
        $this->_authorizeFrontendAccess($action);
        
        return $this;
    }
    
    /**
     * Called after customer is authenticated
     * 
     * @param Varien_Event_Observer $observer
     * @return Ionoi_Authorization_Model_Observer
     */
    public function onCustomerAuthenticated($observer)
    {
        if (!Mage::helper('authorization/store')->isActive()) {
            return $this;
        }
        
        /* @var $action Mage_Customer_Model_Customer */
        $customer = $observer->getEvent()->getModel();
        
        $this->_authorizeCustomerAuthentication($customer);
       
        return $this;
    }
    
    /**
     * Authorize store access
     * 
     * @param Mage_Core_Controller_Varien_Action $action
     */
    protected function _authorizeFrontendAccess($action)
    {
        /* @var $session Mage_Customer_Model_Session */
        $session = Mage::getSingleton('customer/session');
        /* @var $helper Ionoi_Authorization_Helper_Store */
        $helper = Mage::helper('authorization/store');
        
        if (!$helper->isAuthorized($session->getCustomer())) {
            // collect access data
            $request = $action->getRequest();
            $path = $action->getFullActionName('/');
            
            // user defined url are always allowed
            $allowed = $helper->getPublicUrls();
            if (preg_match($allowed, $path)) {
                return;
            }
            
            // public pages are always allowed
            $allowed = 'cms/';
            if (!strncmp($path, $allowed, strlen($allowed))) {
                $identifier = $request->getParam('page_id', $request->getParam('id', 
                    Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_HOME_PAGE)));
                $page = Mage::getModel('cms/page')->load($identifier);
                
                if (in_array($page->getIdentifier(), $helper->getPublicCmsPages()) 
                    || in_array($page->getId(), $helper->getPublicCmsPages())
                ) {
                    return;
                }
            }
            
            // collect redirect data
            $url = null;
            $parameters = null;
            
            // check login redirect
            if (!$session->isLoggedIn() 
                && $helper->getAnonymousCustomerRedirect() == Ionoi_Authorization_Helper_Store::LOGIN_REDIRECT) {
                // collect redirect data
                $url = Mage_Customer_Helper_Data::ROUTE_ACCOUNT_LOGIN;
                $parameters = Mage::helper('customer')->getLoginUrlParams();
                $message = $helper->getErrorMessage();
                
                // add message
                if (!empty($message)) {
                    $session->addError(Mage::helper('core')->escapeHtml($message));
                }
            } else if ($helper->getAnonymousCustomerRedirect() == Ionoi_Authorization_Helper_Store::PAGE_REDIRECT
                || $helper->getUnauthorizedCustomerRedirect() == Ionoi_Authorization_Helper_Store::PAGE_REDIRECT) {
                $url = $helper->getErrorPage();
                
                if (is_int($url)) {
                    $parameters = array('id' => $url);
                    $url = 'cms/view/page';
                }
                
            } else {
                $url = $helper->getCustomRedirectUrl();
            }
            
            // force redirect
            $exception = new Ionoi_Authorization_Controller_Varien_Exception();
            $exception->prepareRedirect($url, $parameters);
            throw $exception;
        }
    }
    
    /**
     * Authorize customer login
     * 
     * @param Mage_Customer_Model_Customer $customer
     */
    protected function _authorizeCustomerAuthentication($customer)
    {
        /* @var $helper Ionoi_Authorization_Helper_Store */
        $helper = Mage::helper('authorization/store');
        
        if (!$helper->isAuthorized($customer)) {
            throw Mage::exception('Mage_Core', Mage::helper('customer')->__('Invalid login or password.'),
                Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD
            );
        }
    }
}
