<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Transport template storage
 */
class Storage
{
    /**
     * Transport config path
     */
    const XML_CONFIG_TRANSPORT = 'trans_email/ident_{{IDENTITY}}/transport';

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Sender email identifier
     *
     * @var string
     */
    private $emailIdentity = '';

    /**
     * Email store identifier
     *
     * @var string
     */
    private $storeId = '';

    /**
     * Email template identifier
     *
     * @var string
     */
    private $templateId = '';

    /**
     * Email body text
     *
     * @var string
     */
    private $body = '';

    /**
     * Email subject
     *
     * @var string
     */
    private $subject = '';

    /**
     * Email template type
     *
     * @var string
     */
    private $type = '';

    /**
     * Email from address
     *
     * @var string
     */
    private $from = '';

    /**
     * Email to addresses
     *
     * @var string[]
     */
    private $to = [];

    /**
     * Email cc addresses
     *
     * @var string[]
     */
    private $cc = [];

    /**
     * Email bcc addresses
     *
     * @var string[]
     */
    private $bcc = [];

    /**
     * Email reply to address
     *
     * @var string
     */
    private $replyTo = '';

    /**
     * Initialize storage
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Set email identifier
     *
     * @param string $emailIdentity
     * @return $this
     */
    public function setEmailIdentity($emailIdentity)
    {
        $this->emailIdentity = $emailIdentity;

        return $this;
    }

    /**
     * Retrieve email identifier
     *
     * @return string
     */
    public function getEmailIdentity()
    {
        return $this->emailIdentity;
    }

    /**
     * Set store identifier
     *
     * @param string $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * Retrieve store identifier
     *
     * @return string
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Set template identifier
     *
     * @param string $templateId
     * @return $this
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Retrieve template identifier
     *
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Set email body text
     *
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Retrieve email body text
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set email subject
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Retrieve email subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set email template type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Retrieve email template type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Retrieve email transport identifier
     *
     * @return string
     */
    public function getTransport()
    {
        return $this->getConfigValue(self::XML_CONFIG_TRANSPORT);
    }

    /**
     * Set from address
     *
     * @param array|string $address
     * @param string $name
     * @return $this
     */
    public function setFrom($address, $name = '')
    {
        if (is_array($address)) {
            $this->from = (string)current($this->prepareAddress($address));
        } else {
            $this->from = $this->formatAddress($address, $name);
        }
        return $this;
    }

    /**
     * Retrieve from address
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Add to address
     *
     * @param array|string $address
     * @param string $name
     * @return $this
     */
    public function addTo($address, $name = '')
    {
        $this->to += $this->prepareAddress($address, $name);

        return $this;
    }

    /**
     * Retrieve to address
     *
     * @return string[]
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Add cc address
     *
     * @param array|string $address
     * @param string $name
     * @return $this
     */
    public function addCc($address, $name = '')
    {
        $this->cc += $this->prepareAddress($address, $name);

        return $this;
    }

    /**
     * Retrieve cc address
     *
     * @return string[]
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Add bcc address
     *
     * @param array|string $address
     * @return $this
     */
    public function addBcc($address)
    {
        $this->bcc += $this->prepareAddress($address);

        return $this;
    }

    /**
     * Retrieve bcc address
     *
     * @return string[]
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set reply to address
     *
     * @param string $address
     * @return $this
     */
    public function setReplyTo($address, $name = null)
    {
        $this->replyTo = $this->formatAddress($address, $name);

        return $this;
    }

    /**
     * Retrieve reply to address
     *
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Retrieve store configuration value
     *
     * @param string $path
     * @return string
     */
    public function getConfigValue($path)
    {
        $path = str_replace('{{IDENTITY}}', $this->getEmailIdentity(), $path);
        return $this->scopeConfig
            ->getValue($path, ScopeInterface::SCOPE_STORE, $this->getStoreId());
    }

    /**
     * Format address string
     *
     * @param string $email
     * @param string|null $name
     * @return string
     */
    private function formatAddress(string $email, $name = null)
    {
        return $name ? sprintf('%s (%s)', $name, $email) : $email;
    }

    /**
     * Prepare address
     *
     * @param array|string $address
     * @param string $name
     * @return string[]
     */
    private function prepareAddress($address, $name = '')
    {
        $addressList = [];
        if (is_array($address)) {
            $addressList += $this->prepareAddresses($address);
        } elseif (is_string($address)) {
            $addressList[$address] = $this->formatAddress($address, $name);
        }
        return $addressList;
    }

    /**
     * Prepare addresses
     *
     * @param array $addresses
     * @return string[]
     */
    private function prepareAddresses(array $addresses)
    {
        $addressList = [];
        foreach ($addresses as $key => $value) {
            if (is_int($key) || is_numeric($key)) {
                $addressList[$value] = $this->formatAddress($value);
            } elseif (is_string($key)) {
                $addressList[$key] = $this->formatAddress($key, $value);
            }
        }
        return $addressList;
    }

    /**
     * Clean object state
     *
     * @return $this
     */
    public function clean()
    {
        $this->storeId = '';
        $this->templateId = '';
        $this->emailIdentity = '';
        $this->subject = '';
        $this->body = '';
        $this->type = '';
        $this->from = '';
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->replyTo = '';

        return $this;
    }
}
