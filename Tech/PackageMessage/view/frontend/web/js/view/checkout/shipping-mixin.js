/**
* Tech_PackageMessage extension
* @category Tech
* @package Tech_PackageMessage
* @copyright Copyright (c) 2020
*/

define( function () {
    'use strict';

    var mixin = {
        default: {
            ormdMessageTemplate: 'Tech_PackageMessage/checkout/shipping-address/ormd-message'
        },

        getOrmd: function() {
            var ormdItems = window.chekcoutConfig.quoteData.ormd_items;

            if(ormdItems.length > 0) {
                return ormdItems;
            }

            return false;
        }
    };

    return function(target) {
        return target.extend(mixin);
    }
});
