/**
* Tech_Core extension
* @category Tech
* @package Tech_PackageMessage
*/

var config = {
    map: {
        '*': {
            'Magento_Checkout/template/shipping-address/shipping-method-list.html':
            	'Tech_PackageMessage/template/checkout/shipping-address/shipping-method-list.html'
        }
    },
    config: {
    	mixins: {
    		'Magento_Checkout/js/view/shipping': {
    			'Tech_PackageMessage/js/view/checkout/shipping-mixin': true

    		}
    	}
    }
};
