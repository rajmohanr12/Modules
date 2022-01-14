<?php
/**
 * @package     TechLeos/Donate
 * @author      code@techleos.com
 * @copyright   Copyright © Techleos. All rights reserved.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'TechLeos_Donate',
    __DIR__
);
