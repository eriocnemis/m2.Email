<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;

/**
 * Email transport factory
 */
class TransportFactory
{
    /**
     * Transport config
     *
     * @var Config
     */
    private $config;

    /**
     * Object Manager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Initialize factory
     *
     * @param Config $config
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        Config $config,
        ObjectManagerInterface $objectManager
    ) {
        $this->config = $config;
        $this->objectManager = $objectManager;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param string $name
     * @return TransportInterface
     */
    public function create(string $name)
    {
        $transport = $this->objectManager->create($this->config->getClass($name));
        if (!$transport instanceof TransportInterface) {
            throw new LocalizedException(
                __('Transport must implement %1.', TransportInterface::class)
            );
        }
        return $transport;
    }
}
