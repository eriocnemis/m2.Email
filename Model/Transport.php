<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model;

use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Phrase;
use Eriocnemis\Email\Model\Email\Manager;
use Eriocnemis\Email\Model\Transport\TransportFactory;
use Eriocnemis\Email\Model\Transport\Storage;

/**
 * Email transport
 */
class Transport implements TransportInterface
{
    /**
     * Email transport factory
     *
     * @var TransportFactory
     */
    private $transportFactory;

    /**
     * Email message
     *
     * @var MessageInterface
     */
    private $message;

    /**
     * Email management
     *
     * @var Manager
     */
    private $manager;

    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Initialize transport
     *
     * @param MessageInterface $message
     * @param Manager $manager
     * @param Storage $storage
     * @param TransportFactory $transportFactory
     */
    public function __construct(
        MessageInterface $message,
        Manager $manager,
        Storage $storage,
        TransportFactory $transportFactory
    ) {
        $this->message = $message;
        $this->manager = $manager;
        $this->storage = $storage;
        $this->transportFactory = $transportFactory;
    }

    /**
     * Send a mail using selected transport
     *
     * @return void
     * @throws MailException
     */
    public function sendMessage()
    {
        try {
            $this->manager->open($this->storage);
            $this->getTransport()->send(
                $this->getMessage()->getRawMessage()
            );
        } catch (\Exception $e) {
            $this->manager->setError($e->getMessage());
            throw new MailException(new Phrase($e->getMessage()), $e);
        } finally {
            $this->manager->close();
            $this->storage->clean();
        }
    }

    /**
     * Retrieve message
     *
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Retrieve transport
     *
     * @return \Eriocnemis\Email\Model\Transport\TransportInterface
     */
    private function getTransport()
    {
        return $this->transportFactory->create(
            $this->storage->getTransport()
        );
    }
}
