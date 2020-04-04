<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

use Zend\Mail\Message;
use Zend\Mail\Transport\Factory as TransportFactory;

/**
 * Email zend abstract transport
 */
abstract class TransportAbstract implements TransportInterface
{
    /**
     * Convert message to zend object
     *
     * @param string $message
     * @return Message
     */
    protected function prepareMessage(string $message)
    {
        return Message::fromString($message);
    }

    /**
     * Send a mail message
     *
     * @param string $message
     * @return void
     */
    public function send(string $message)
    {
        $this->getTransport()->send(
            $this->prepareMessage($message)
        );
    }

    /**
     * Retrieve file transport
     *
     * @return \Zend\Mail\Transport\TransportInterface
     */
    protected function getTransport()
    {
        return TransportFactory::create($this->getConfig());
    }

    /**
     * Retrieve transport config
     *
     * @return array
     */
    abstract protected function getConfig();
}
