<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Config\Source;

use Eriocnemis\Email\Model\Transport\Config;

/**
 * Transport source
 */
class Transport extends AbstractSource
{
    /**
     * Source options
     *
     * @var array
     */
    private $options;

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
     * Retrieve options in key-value format
     *
     * @return array
     */
    public function toArray()
    {
        if (null === $this->options) {
            foreach ($this->config->getAvailable() as $value) {
                $this->options[$value] = $this->config->getLabel($value);
            }
        }
        return $this->options;
    }
}
