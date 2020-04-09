<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

use Eriocnemis\Email\Model\Transport\Config;
use Eriocnemis\Email\Model\Transport\Storage;
use Eriocnemis\Email\Model\EmailFactory;

/**
 * Email converter
 */
class Converter
{
    /**
     * Email factory
     *
     * @var EmailFactory
     */
    private $emailFactory;

    /**
     * Transport config
     *
     * @var Config
     */
    private $config;

    /**
     * Initialize converter
     *
     * @param EmailFactory $emailFactory
     * @param Config $config
     */
    public function __construct(
        EmailFactory $emailFactory,
        Config $config
    ) {
        $this->emailFactory = $emailFactory;
        $this->config = $config;
    }

    /**
     * Converts a message in email model
     *
     * @param Storage $storage
     * @return \Eriocnemis\Email\Model\Email
     */
    public function convert(Storage $storage)
    {
        /** @var \Eriocnemis\Email\Model\Email $email */
        $email = $this->emailFactory->create();

        $email->setSender($storage->getSender());
        $email->setReplyTo($storage->getReplyTo());

        $email->setRecipient($this->prepareEmail($storage->getRecipient()));
        $email->setCc($this->prepareEmail($storage->getCc()));
        $email->setBcc($this->prepareEmail($storage->getBcc()));

        $email->setBody($storage->getBody());
        $email->setSubject($storage->getSubject());
        $email->setOriginal(convert_uuencode(gzencode($storage->getOriginal())));
        $email->setType($storage->getType());

        $email->setStoreId($storage->getStoreId());
        $email->setTemplateId($storage->getTemplateId());
        $email->setTransport($storage->getTransport());
        $email->setDummy(
            (int)$this->config->isDummy($storage->getTransport())
        );
        return $email;
    }

    /**
     * Retrieve prepared emails
     *
     * @param array $addressList
     * @return string
     */
    protected function prepareEmail(array $addressList)
    {
        return implode(',', array_values($addressList));
    }
}
