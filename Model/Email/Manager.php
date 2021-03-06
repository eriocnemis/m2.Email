<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

use Zend\Mail\AddressList;
use Zend\Mail\Message;
use Eriocnemis\Email\Helper\Data as Helper;
use Eriocnemis\Email\Model\Email;
use Eriocnemis\Email\Model\ResourceModel\Email\CollectionFactory;
use Eriocnemis\Email\Model\Constant;

/**
 * Email manager
 */
class Manager
{
    /**
     * Helper
     *
     * @var Helper
     */
    protected $helper;

    /**
     * Email converter
     *
     * @var Converter
     */
    protected $converter;

    /**
     * Email collection
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Mail log
     *
     * @var Email
     */
    protected $email;

    /**
     * Timer
     *
     * @var Timer
     */
    protected $timer;

    /**
     * Initialize manager
     *
     * @param Helper $helper
     * @param Timer $timer
     * @param Converter $converter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Helper $helper,
        Timer $timer,
        Converter $converter,
        CollectionFactory $collectionFactory
    ) {
        $this->helper = $helper;
        $this->timer = $timer;
        $this->converter = $converter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Open new email record
     *
     * @param Message $message
     * @return void
     */
    public function open(Message $message)
    {
        if ($this->isLogEnabled()) {
            $this->timer->start();
            $this->email = $this->converter->convert($message);
            $this->email->save();
        }
    }

    /**
     * Delete expire email
     *
     * @return void
     */
    public function deleteExpire()
    {
        if ($this->helper->isCleanEnabled()) {
            $collection = $this->collectionFactory->create();
            $collection->addExpireDateFilter(
                $this->helper->getDays()
            )->walk('delete');
        }
    }

    /**
     * Set error to email
     *
     * @return void
     */
    public function setError($error)
    {
        if ($this->email instanceof Email) {
            $this->email->setError($error);
            $this->email->setStatus(Constant::STATUS_FAILED);
            $this->email->save();
        }
    }

    /**
     * Close email record
     *
     * @return void
     */
    public function close()
    {
        if ($this->email instanceof Email) {
            $this->timer->stop();
            $this->email->setDuration((string)$this->timer->get());
            if ($this->email->getStatus() !== Constant::STATUS_FAILED) {
                $this->email->setStatus(Constant::STATUS_SUCCESS);
            }
            $this->email->save();
        }
    }

    /**
     * Check log functionality should be enabled
     *
     * @param string $storeId
     * @return bool
     */
    protected function isLogEnabled($storeId = null)
    {
        return $this->helper->isLogEnabled($storeId);
    }
}
