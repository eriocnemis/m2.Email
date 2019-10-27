<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Plugin\Framework\Mail;

use Zend\Mail\Message;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Phrase;
use Eriocnemis\Email\Helper\Data as Helper;
use Eriocnemis\Email\Model\Email\Manager;

/**
 * Transport plugin
 */
class TransportInterfacePlugin
{
    /**
     * Email management
     *
     * @var Manager
     */
    protected $manager;

    /**
     * Helper
     *
     * @var Helper
     */
    protected $helper;

    /**
     * Initialize transport
     *
     * @param Manager $manager
     * @param Helper $helper
     */
    public function __construct(
        Manager $manager,
        Helper $helper
    ) {
        $this->manager = $manager;
        $this->helper = $helper;
    }

    /**
     * Send a mail using this transport
     *
     * @param TransportInterface $subject
     * @param callable $proceed
     * @return void
     * @throws MailException
     */
    public function aroundSendMessage(TransportInterface $subject, callable $proceed)
    {
        try {
            /** @var Message $message */
            $message = Message::fromString(
                $subject->getMessage()->getRawMessage()
            );
            $this->manager->open($message);

            if (!$this->helper->isDummy()) {
                $proceed();
            }
        } catch (\Exception $e) {
            $this->manager->setError($e->getMessage());
            throw new MailException(new Phrase($e->getMessage()), $e);
        } finally {
            $this->manager->close();
        }
    }
}
