<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model;

use Zend\Mail\Message;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Phrase;
use Eriocnemis\Email\Model\Email\Manager;
use Eriocnemis\Email\Model\Transport\TransportFactory;
use Eriocnemis\Email\Model\Transport\Identity;

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
     * Email template identity
     *
     * @var Identity
     */
    private $identity;

    /**
     * Initialize transport
     *
     * @param MessageInterface $message
     * @param Manager $manager
     * @param Identity $identity
     * @param TransportFactory $transportFactory
     */
    public function __construct(
        MessageInterface $message,
        Manager $manager,
        Identity $identity,
        TransportFactory $transportFactory
    ) {
        $this->message = $message;
        $this->manager = $manager;
        $this->identity = $identity;
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
            /** @var Message $message */
            $message = Message::fromString(
                $this->getMessage()->getRawMessage()
            );

            $this->manager->open($message);
            $this->getTransport()->send($this->getMessage()->getRawMessage());
        } catch (\Exception $e) {
            $this->manager->setError($e->getMessage());
            throw new MailException(new Phrase($e->getMessage()), $e);
        } finally {
            $this->manager->close();
            $this->identity->reset();
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
     * @return \Zend\Mail\Transport\TransportInterface
     */
    private function getTransport()
    {
        return $this->transportFactory->create(
            $this->identity->getTransport()
        );
    }
}
