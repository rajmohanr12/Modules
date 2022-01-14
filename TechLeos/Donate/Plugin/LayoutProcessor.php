<?php
/**
 * @package     TechLeos/Donate
 * @author      code@techleos.com
 * @copyright   Copyright © Techleos. All rights reserved.
 */
declare(strict_types=1);

namespace TechLeos\Donate\Plugin;

use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Directory\Model\RegionFactory;
use Magento\Checkout\Block\Checkout\LayoutProcessor as CheckoutProcessor;
use Magento\Checkout\Model\Session;

class LayoutProcessor
{
    
    protected $regionFactory;
	
	/**
     * @var HttpContext
     */
    private $httpContext;
	
    /**
     * Constructor
     *
     * @param RegionFactory $checkoutSession
     * @param HttpContext $httpContext
     */
    public function __construct(
        Session $session,
        RegionFactory $regionFactory,
		HttpContext $httpContext
    ) {
        $this->checkoutSession = $session;
		$this->regionFactory = $regionFactory;
		$this->httpContext = $httpContext;
    }

	/**
     * @param CheckoutProcessor $subject
     * @param array $jsLayout
     * 
     * @return array
     */
    public function afterProcess(
        CheckoutProcessor $subject,
        array  $jsLayout
    ) {       
		$quote = $this->checkoutSession->getQuote();       
		$isDonate = 0;
        $visible = true;
			
        foreach ($quote->getAllVisibleItems() as $item) {
        	if ($item->getDonate()) {
        		$isDonate++;            
        	}
        }       

        if ($isDonate == $quote->getItemsCount()) {
            $visible = false;
            
            /**Static Shipping Address */
            $streetName1 = '3309 Clarence Court';
            $streetName2 = 'asdasClinton';
            $city = 'California';
            $zipCode = '90602';
            $telephone = '9994500234';
            $countryCode = 'US';
            $region = 'California';
            $firstName = 'John';
            $lastName = 'David';

            $regionCode = $this->getRegionCode($region, $countryCode);
            $regionId = $this->getRegionId($region, $countryCode);

            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['config']['additionalClasses'] = 'novisible';
            
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['config']['additionalClasses'] = 'street novisible';            
        }
        
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['firstname']['value'] = $firstName ?? '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['firstname']['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['lastname']['value'] = $lastName ?? '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['lastname']['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['company']['value'] = '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['company']['visible'] = $visible;
                    
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][0]['value'] = (isset($streetName1)) ? $streetName1 : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][0]['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][1]['value'] = (isset($streetName2)) ? $streetName2 : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][1]['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][2]['value'] = (isset($streetName3)) ? $streetName3 : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][2]['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['city']['value'] =  (isset($city)) ? $city : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['city']['visible'] = $visible;
        
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['value'] = (isset($countryCode)) ? $countryCode : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['value'] = (isset($regionId)) ? $regionId : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id']['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['region']['value'] = (isset($regionCode)) ? $regionCode : '';

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['postcode']['value'] = (isset($zipCode)) ? $zipCode : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['postcode']['visible'] = $visible;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['value'] = (isset($telephone)) ? $telephone : '';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['visible'] = $visible;
        
		return $jsLayout;
	}
	
	private function getRegionCode($region, $countryId) {
	    return $this->regionFactory->create()->loadByName($region, $countryId)->getCode();
	}

    private function getRegionId($region, $countryId) {
	    return $this->regionFactory->create()->loadByName($region, $countryId)->getId();
	}   
}
