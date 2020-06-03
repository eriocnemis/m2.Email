<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Eriocnemis\Email\Model\ResourceModel\Email as EmailResource;

/**
 * Email model
 *
 * @method Email setRecipient(string $email)
 * @method string getRecipient()
 * @method Email setCc(string $cc)
 * @method string getCc()
 * @method Email setBcc(string $bcc)
 * @method string getBcc()
 * @method Email setSender(string $email)
 * @method string getSender()
 * @method Email setOriginal(string $message)
 * @method string getOriginal()
 * @method Email setReplyTo(string $replyTo)
 * @method string getReplyTo()
 * @method Email setSubject(string $subject)
 * @method string getSubject()
 * @method Email setBody(string $message)
 * @method string getBody()
 * @method Email setMode(string|null $mode)
 * @method string|null getMode()
 * @method Email setError(string $error)
 * @method string getError()
 * @method Email setStatus(string $status)
 * @method string getStatus()
 * @method Email setType(string $type)
 * @method string getType()
 * @method Email setStoreId(string $storeId)
 * @method string getStoreId()
 * @method Email setTemplateId(string $templateId)
 * @method string getTemplateId()
 * @method Email setTransport(string $transport)
 * @method string getTransport()
 * @method Email setDuration(float $duration)
 * @method float getDuration()
 * @method Email setCreatedAt(string $createdAt)
 * @method string getCreatedAt()
 * @method Email setUpdatedAt(string $updateAt)
 * @method string getUpdatedAt()
 */
class Email extends AbstractModel implements IdentityInterface
{
    /**
     * Cache tag name
     */
    const CACHE_TAG = 'ERIOCNEMIS_EMAIL';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'eriocnemis_email';

    /**
     * Parameter name in event
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'email';

    /**
     * Model cache tag for clear cache in after save and after delete
     * When you use true - all cache will be clean
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Initialize model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(EmailResource::class);
    }

    /**
     * Retrieve unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        $tags = [];
        if ($this->getId()) {
            $tags[] = self::CACHE_TAG . '_' . $this->getId();
        }
        return $tags;
    }
}
