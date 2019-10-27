<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Helper
 */
class Data extends AbstractHelper
{
    /**
     * Dummy config path
     */
    const XML_DUMMY = 'system/smtp/dummy';

    /**
     * Log enabled config path
     */
    const XML_ENABLED = 'system/eriocnemis_email_log/enabled';

    /**
     * Clean enabled config path
     */
    const XML_CLEAN_ENABLED = 'system/eriocnemis_email_log/clean';

    /**
     * Days config path
     */
    const XML_DAYS = 'system/eriocnemis_email_log/days';

    /**
     * Check log functionality should be enabled
     *
     * @param string $storeId
     * @return bool
     */
    public function isLogEnabled($storeId = null)
    {
        return $this->isSetFlag(static::XML_ENABLED, $storeId);
    }

    /**
     * Check clean functionality should be enabled
     *
     * @param string $storeId
     * @return bool
     */
    public function isCleanEnabled($storeId = null)
    {
        return $this->isSetFlag(static::XML_CLEAN_ENABLED, $storeId);
    }

    /**
     * Check dummy mode
     *
     * @param string $storeId
     * @return bool
     */
    public function isDummy($storeId = null)
    {
        return $this->isSetFlag(static::XML_DUMMY, $storeId);
    }

    /**
     * Retrieve days
     *
     * @param string $storeId
     * @return string
     */
    public function getDays($storeId = null)
    {
        return $this->getValue(self::XML_DAYS, $storeId);
    }

    /**
     * Retrieve config value by path and scope
     *
     * @param string $path
     * @param string $storeId
     * @return mixed
     */
    protected function getValue($path, $storeId = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Retrieve config flag
     *
     * @param string $path
     * @param string $storeId
     * @return bool
     */
    protected function isSetFlag($path, $storeId = null)
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
