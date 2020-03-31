<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

/**
 * Transport config
 */
class Config
{
    /**
     * Config list
     *
     * @var array
     */
    private $config;

    /**
     * Validate format of forms configuration array
     *
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config)
    {
        foreach ($config as $name => $data) {
            if (!is_string($name) || empty($name)) {
                throw new \InvalidArgumentException('Name for a Transport has to be specified.');
            }
            if (empty($data['class'])) {
                throw new \InvalidArgumentException('Class for a Transport has to be specified.');
            }
            if (empty($data['label'])) {
                throw new \InvalidArgumentException('Label for a Transport form has to be specified.');
            }
        }
        $this->config = $config;
    }

    /**
     * Retrieve unique names of all available transports
     *
     * @return array
     */
    public function getAvailable()
    {
        return array_keys($this->config);
    }

    /**
     * Retrieve already class name that corresponds to transport
     *
     * @param string $name
     * @return string|null
     */
    public function getClass($name)
    {
        return $this->config[$name]['class'] ?? null;
    }

    /**
     * Retrieve already translated label that corresponds to transport
     *
     * @param string $name
     * @return string|null
     */
    public function getLabel($name)
    {
        return $this->config[$name]['label'] ?? null;
    }

    /**
     * Checks is dummy mode
     *
     * @param string $name
     * @return bool
     */
    public function isDummy($name)
    {
        return (bool)$this->config[$name]['dummy'] ?? false;
    }
}
