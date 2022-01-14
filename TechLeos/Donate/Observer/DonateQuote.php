<?php
/**
 * @package     TechLeos/Donate
 * @author      code@techleos.com
 * @copyright   Copyright © Techleos. All rights reserved.
 */
declare(strict_types=1);

namespace TechLeos\Donate\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface;

class DonateQuote implements ObserverInterface
{
    const QUOTE_DONATE_KEY = 'donate';
    protected $_request;

    public function __construct(
       RequestInterface $request,
        LoggerInterface $logger
    ) {
        $this->_request = $request;
        $this->logger = $logger;
    }
    public function execute(Observer $observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $params = $this->_request->getParams();
        if (array_key_exists(self::QUOTE_DONATE_KEY, $params)) {
            $quoteItem->setDonate($params[self::QUOTE_DONATE_KEY]);            
        } else {
			$quoteItem->setDonate(0);
		}
    }
}
