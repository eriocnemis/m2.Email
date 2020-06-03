<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Plugin\Framework\Mail\Template;

use Magento\Framework\Mail\Template\TransportBuilder as Subject;
use Eriocnemis\Email\Model\Transport\Storage;

/**
 * Email transport builder plugin
 */
class TransportBuilderPlugin
{
    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Initialize builder
     *
     * @param Storage $storage
     */
    public function __construct(
        Storage $storage
    ) {
        $this->storage = $storage;
    }

    /**
     * Set mail from address by scopeId
     *
     * @param Subject $subject
     * @param string|string[] $from
     * @param string|int $scopeId
     * @return null
     */
    public function beforeSetFromByScope(Subject $subject, $from, $scopeId = null)
    {
        if (is_string($from)) {
            $this->storage->setEmailIdentity($from);
        }
        return null;
    }

    /**
     * Set template identifier
     *
     * @param Subject $subject
     * @param string $templateIdentifier
     * @return null
     */
    public function beforeSetTemplateIdentifier(Subject $subject, $templateIdentifier)
    {
        $this->storage->setTemplateId($templateIdentifier);

        return null;
    }

    /**
     * Add to address
     *
     * @param Subject $subject
     * @param string[]|string $address
     * @param string $name
     * @return null
     */
    public function beforeAddTo(Subject $subject, $address, $name = '')
    {
        $this->storage->addRecipient($address, $name);

        return null;
    }

    /**
     * Add cc address
     *
     * @param Subject $subject
     * @param string[]|string $address
     * @param string $name
     * @return null
     */
    public function beforeAddCc(Subject $subject, $address, $name = '')
    {
        $this->storage->addCc($address, $name);

        return null;
    }

    /**
     * Add bcc address
     *
     * @param Subject $subject
     * @param string[]|string $address
     * @param string $name
     * @return null
     */
    public function beforeAddBcc(Subject $subject, $address, $name = '')
    {
        $this->storage->addBcc($address, $name);

        return null;
    }

    /**
     * Set reply to address
     *
     * @param Subject $subject
     * @param string $address
     * @param string $name
     * @return null
     */
    public function beforeSetReplyTo(Subject $subject, $address, $name = '')
    {
        $this->storage->setReplyTo($address, $name);

        return null;
    }

    /**
     * Set from address
     *
     * @param Subject $subject
     * @param string|string[] $from
     * @return null
     */
    public function beforeSetFrom(Subject $subject, $from)
    {
        $this->storage->setSender($from);

        return null;
    }

    /**
     * Set template options
     *
     * @param Subject $subject
     * @param string[] $templateOptions
     * @return null
     */
    public function beforeSetTemplateOptions(Subject $subject, $templateOptions)
    {
        if (isset($templateOptions['store'])) {
            $this->storage->setStoreId($templateOptions['store']);
        }
        return null;
    }
}
