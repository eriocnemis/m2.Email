<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\ResourceModel\Email;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Eriocnemis\Email\Model\ResourceModel\Email as EmailResource;
use Eriocnemis\Email\Model\Email;

/**
 * Email collection
 */
class Collection extends AbstractCollection
{
    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'eriocnemis_email_collection';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'collection';

    /**
     * Identifier field name for collection items
     *
     * @var string
     */
    protected $_idFieldName = 'email_id';

    /**
     * Initialize Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Email::class, EmailResource::class);
    }

    /**
     * Limit collection by expire date
     *
     * @param string $interval
     * @return $this
     */
    public function addExpireDateFilter($interval)
    {
        $this->getSelect()->where(
            "created_at <= NOW() - INTERVAL ? DAY",
            $interval
        );
        return $this;
    }

    /**
     * Limit collection by store
     *
     * @param string $storeId
     * @return $this
     */
    public function addStoreIdFilter($storeId)
    {
        return $this->addFieldToFilter('store_id', $storeId);
    }
}
