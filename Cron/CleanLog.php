<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Cron;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Eriocnemis\Email\Model\Email\Manager;

/**
 * Clean log job
 */
class CleanLog
{
    /**
     * Last clean config path
     */
    const XML_CONFIG_LAST_CLEAN = 'system/eriocnemis_email/last_clean';

    /**
     * Email management
     *
     * @var Manager
     */
    private $manager;

    /**
     * Config writer
     *
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * Locale date
     *
     * @var TimezoneInterface
     */
    private $localeDate;

    /**
     * Store repository
     *
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * Initialize job
     *
     * @param Manager $logManager
     * @param WriterInterface $configWriter
     * @param TimezoneInterface $localeDate
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        Manager $logManager,
        WriterInterface $configWriter,
        TimezoneInterface $localeDate,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->manager = $logManager;
        $this->configWriter = $configWriter;
        $this->localeDate = $localeDate;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Clean log
     *
     * @return void
     */
    public function execute()
    {
        foreach ($this->storeRepository->getList() as $store) {
            $this->manager->deleteExpire($store->getId());
            $this->updateLastClean($store->getId());
        }
    }

    /**
     * Update last clean field
     *
     * @param string $storeId
     * @return void
     */
    private function updateLastClean($storeId)
    {
        $this->configWriter->save(
            self::XML_CONFIG_LAST_CLEAN,
            $this->localeDate->formatDate(),
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
