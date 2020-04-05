<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

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
    protected $emailFactory;

    /**
     * Initialize converter
     *
     * @param EmailFactory $emailFactory
     */
    public function __construct(
        EmailFactory $emailFactory
    ) {
        $this->emailFactory = $emailFactory;
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

        $email->setFrom($storage->getFrom());
        $email->setReplyTo($storage->getReplyTo());

        $email->setTo($this->prepareEmail($storage->getTo()));
        $email->setCc($this->prepareEmail($storage->getCc()));
        $email->setBcc($this->prepareEmail($storage->getBcc()));

        $email->setBody($storage->getBody());
        $email->setSubject($storage->getSubject());
        $email->setType($storage->getType());

        $email->setStoreId($storage->getStoreId());
        $email->setTemplateId($storage->getTemplateId());
        $email->setTransport($storage->getTransport());

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
