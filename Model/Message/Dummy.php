<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Message;

use Magento\Framework\UrlInterface;
use Magento\Framework\Notification\MessageInterface;
use Eriocnemis\Email\Helper\Data as Helper;

/**
 * Message about dummy emails
 */
class Dummy implements MessageInterface
{
    /**
     * Helper
     *
     * @var Helper
     */
    protected $helper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Initialize message
     *
     * @param Helper $helper
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Helper $helper,
        UrlInterface $urlBuilder
    ) {
        $this->helper = $helper;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Check whether enabled dummy mode
     *
     * @return bool
     */
    public function isDisplayed()
    {
        return $this->helper->isDummy();
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
            'Email dummy mode <a href="%1">enabled</a> for one or more stores. Emails are not sent to customers.',
            $this->urlBuilder->getUrl('adminhtml/system_config/edit', ['section' => 'system'])
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
