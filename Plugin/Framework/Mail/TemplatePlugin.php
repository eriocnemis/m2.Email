<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Plugin\Framework\Mail;

use Magento\Framework\Mail\TemplateInterface as Subject;
use Eriocnemis\Email\Model\Transport\Storage;

/**
 * Email template plugin
 */
class TemplatePlugin
{
    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Initialize resolver
     *
     * @param Storage $storage
     */
    public function __construct(
        Storage $storage
    ) {
        $this->storage = $storage;
    }

    /**
     * Retrieve processed template
     *
     * @param Subject $subject
     * @param string $result
     * @return string
     */
    public function afterProcessTemplate(Subject $subject, $result)
    {
        $this->storage->setBody($result);

        return $result;
    }

    /**
     * Retrieve email subject
     *
     * @param Subject $subject
     * @param string $result
     * @return string
     */
    public function afterGetSubject(Subject $subject, $result)
    {
        $this->storage->setSubject($result);

        return $result;
    }

    /**
     * Retrieve email template type
     *
     * @param Subject $subject
     * @param string $result
     * @return string
     */
    public function afterGetType(Subject $subject, $result)
    {
        $this->storage->setType($result);

        return $result;
    }
}
