<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

use Zend\Mail\AddressList;
use Zend\Mail\Message;
use Symfony\Polyfill\Mbstring\Mbstring;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;
use Eriocnemis\Email\Helper\Data as Helper;
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
     * Helper
     *
     * @var Helper
     */
    protected $helper;

    /**
     * Initialize converter
     *
     * @param EmailFactory $emailFactory
     * @param Helper $helper
     */
    public function __construct(
        EmailFactory $emailFactory,
        Helper $helper
    ) {
        $this->emailFactory = $emailFactory;
        $this->helper = $helper;
    }

    /**
     * Converts a message in email model
     *
     * @param Message $message
     * @return \Eriocnemis\Email\Model\Email
     */
    public function convert(Message $message)
    {
        /** @var \Eriocnemis\Email\Model\Email $email */
        $email = $this->emailFactory->create();

        $email->setFrom($this->prepareFrom($message->getFrom()));
        $email->setTo($this->prepareEmail($message->getTo()));

        $email->setCc($this->prepareEmail($message->getCc()));
        $email->setBcc($this->prepareEmail($message->getBcc()));
        $email->setReplyTo($this->prepareEmail($message->getReplyTo()));

        $email->setBody($this->getBody($message));
        $email->setSubject((string)$message->getSubject());
        $email->setDummy((int)$this->helper->isDummy());

        return $email;
    }

    /**
     * Retrieve prepared content
     *
     * @param Message $message
     * @return string
     */
    protected function getBody(Message $message)
    {
        $body = '';
        /** @var \Zend\Mail\Header\HeaderInterface $header */
        $header = $message->getHeaders()->get('contenttransferencoding');

        switch ($header->getFieldValue()) {
            case 'quoted-printable':
                $body = quoted_printable_decode($message->getBodyText());
                break;
            case 'base64':
                $body = Mbstring::mb_convert_encoding($message->getBodyText(), 'UTF-8', 'BASE64');
                break;
        }
        return (string)$body;
    }

    /**
     * Retrieve prepared emails
     *
     * @param AddressList $addressList
     * @return string
     */
    protected function prepareEmail(AddressList $addressList)
    {
        $emails = [];
        $addressList->rewind();
        while ($addressList->valid()) {
            $emails[] = $addressList->current()->getEmail();
            $addressList->next();
        }
        return implode(',', $emails);
    }

    /**
     * Retrieve prepared from
     *
     * @param AddressList $addressList
     * @return string
     */
    protected function prepareFrom(AddressList $addressList)
    {
        $addressList->rewind();
        if ($addressList->valid()) {
            return $addressList->current()->getEmail();
        }
        throw new MailException(
            new Phrase(
                'Transport expects either a Sender or at least one From address in the Message;' .
                ' none provided'
            )
        );
    }
}
