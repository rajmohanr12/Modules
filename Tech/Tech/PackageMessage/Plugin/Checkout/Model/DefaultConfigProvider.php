<?php
/**
 * Tech_Core extension
 * @category Tech
 * @package Tech_PackageMessage
 * @copyright Copyright (c) 2020
 */

namespace Tech\PackageMessage\Plugin\Checkout\Model;

use Magento\Checkout\Model\Session as CheckoutSession;

class DefaultConfigProvider
{
    const PACKAGE_ID_ORMD = 'ORMD';

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        CheckoutSession $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Add info about ormd items to quoteData
     * @param \Magento\Checkout\Model\DefaultConfigProvider $subject
     * @param array $result
     * @return array
     */
    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
        array $result
    ) {
        $items = $result['totalsData']['items'];
        $result['quoteData']['ormd_items'] = [];
        foreach ($items as $item) {
            $quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);
            $product = $quoteItem->getProduct();
            $packageId = $product->getAttributeText('package_id');

            if ($packageId = self::PACKAGE_ID_ORMD) {
                $result['quoteData']['ormd_items'][] = ['sku' => $product->getSku(), 'name' => $product->getName()];
            }
        }
        
        return $result;
    }
}
