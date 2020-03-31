<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use \Magento\Framework\Option\ArrayInterface;
use \Eriocnemis\Email\Model\Transport\Config;

/**
 * Transport source
 */
class Transport implements ArrayInterface
{
    /**
     * Transport config
     *
     * @var Config
     */
    private $config;

    /**
     * Initialize source
     *
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Retrieve config options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->config->getAvailable() as $value) {
            $options[] = ['label' => $this->config->getLabel($value), 'value' => $value];
        }
        return $options;
    }
}
