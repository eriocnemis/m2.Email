<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Message;

use Magento\Framework\UrlInterface;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\Config\Structure as ConfigStructure;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Eriocnemis\Email\Model\Transport\Config;

/**
 * Message about dummy emails
 */
class Dummy implements MessageInterface
{
    /**
     * Transport config path
     */
    const XML_CONFIG_TRANSPORT = 'trans_email/{{IDENTITY}}/transport';

    /**
     * Store repository
     *
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * Url builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Transport config
     *
     * @var Config
     */
    private $config;

    /**
     * Configuration structure
     *
     * @var ConfigStructure
     */
    private $configStructure;

    /**
     * Dummy transport list
     *
     * @var string[]
     */
    private $transport = [];

    /**
     * Initialize message
     *
     * @param StoreRepositoryInterface $storeRepository
     * @param ScopeConfigInterface $scopeConfig
     * @param ConfigStructure $configStructure
     * @param UrlInterface $urlBuilder
     * @param Config $config
     */
    public function __construct(
        StoreRepositoryInterface $storeRepository,
        ScopeConfigInterface $scopeConfig,
        ConfigStructure $configStructure,
        UrlInterface $urlBuilder,
        Config $config
    ) {
        $this->storeRepository = $storeRepository;
        $this->configStructure = $configStructure;
        $this->scopeConfig = $scopeConfig;
        $this->urlBuilder = $urlBuilder;
        $this->config = $config;
    }

    /**
     * Check whether enabled dummy mode
     *
     * @return bool
     */
    public function isDisplayed()
    {
        $identities = [];
        /** @var $section \Magento\Config\Model\Config\Structure\Element\Section */
        $section = $this->configStructure->getElement('trans_email');
        /** @var $group \Magento\Config\Model\Config\Structure\Element\Group */
        foreach ($section->getChildren() as $group) {
            $identities[] = $group->getId();
        }

        foreach ($this->storeRepository->getList() as $store) {
            foreach ($identities as $identity) {
                $path = str_replace('{{IDENTITY}}', $identity, self::XML_CONFIG_TRANSPORT);
                $name = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $store->getId());
                if ($this->config->isDummy($name)) {
                    $this->transport[$name] = $this->config->getLabel($name);
                }
            }
        }
        return count($this->transport) > 0;
    }

    /**
     * Retrieve unique message identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return 'eriocnemis_email_dummy';
    }

    /**
     * Retrieve message text
     *
     * @return string
     */
    public function getText()
    {
        return __(
            'One or more stores has <a href="%1">configure a transport</a> that only emulates the sending of email: %2. Emails are not sent to customers.',
            $this->getConfigUrl(),
            implode(', ', $this->transport)
        );
    }

    /**
     * Retrieve config url
     *
     * @return string
     */
    private function getConfigUrl()
    {
        return $this->urlBuilder->getUrl(
            'adminhtml/system_config/edit',
            ['section' => 'trans_email']
        );
    }

    /**
     * Retrieve message severity
     *
     * @return int
     */
    public function getSeverity()
    {
        return self::SEVERITY_NOTICE;
    }
}
