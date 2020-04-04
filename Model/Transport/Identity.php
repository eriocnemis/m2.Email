<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Transport template identity
 */
class Identity
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
    private $emailIdentity;

    /**
     * Email store identifier
     *
     * @var string
     */
    private $storeId;

    /**
     * Email template identifier
     *
     * @var string
     */
    private $templateId;

    /**
     * Initialize identity
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
     * Retrieve email transport identifier
     *
     * @return string
     */
    public function getTransport()
    {
        return $this->getConfigValue(self::XML_CONFIG_TRANSPORT);
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
     * Reset object state
     *
     * @return $this
     */
    public function reset()
    {
        $this->storeId = null;
        $this->templateId = null;
        $this->emailIdentity = null;

        return $this;
    }
}
