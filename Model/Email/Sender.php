<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Eriocnemis\Email\Model\Transport\Config;
use Eriocnemis\Email\Model\Transport\Storage;

/**
 * Email sender
 */
class Sender
{
    /**
     * Transport builder
     *
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Transport config
     *
     * @var Config
     */
    private $config;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize sender
     *
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param Storage $storage
     * @param Config $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        Storage $storage,
        Config $config,
        LoggerInterface $logger
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->storage = $storage;
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Send test email
     *
     * @return void
     */
    public function send()
    {
        $transport = $this->transportBuilder
            ->setTemplateIdentifier('eriocnemis_email_test_template')
            ->setTemplateOptions($this->getTemplateOptions())
            ->setFrom($this->storage->getSender())
            ->addTo($this->storage->getRecipient())
            ->setTemplateVars($this->getTemplateVars())
            ->getTransport();
        /* send email message */
        $transport->sendMessage();
    }

    /**
     * Retrieve template options
     *
     * @return mixed[]
     */
    private function getTemplateOptions()
    {
        return [
            'area' => Area::AREA_FRONTEND,
            'store' => $this->storage->getStoreId()
        ];
    }

    /**
     * Retrieve template vars
     *
     * @return mixed[]
     */
    private function getTemplateVars()
    {
        return [
            'sender' => $this->storage->getSender(),
            'store' => $this->storeManager->getStore($this->storage->getStoreId()),
            'transport' => $this->config->getLabel($this->storage->getTransport())
        ];
    }
}
