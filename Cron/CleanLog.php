<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Cron;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
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
    protected $manager;

    /**
     * Config writer
     *
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * Locale date
     *
     * @var TimezoneInterface
     */
    protected $localeDate;

    /**
     * Initialize Job
     *
     * @param Manager $logManager
     * @param WriterInterface $configWriter
     * @param TimezoneInterface $localeDate
     */
    public function __construct(
        Manager $logManager,
        WriterInterface $configWriter,
        TimezoneInterface $localeDate
    ) {
        $this->manager = $logManager;
        $this->configWriter = $configWriter;
        $this->localeDate = $localeDate;
    }

    /**
     * Clean log
     *
     * @return void
     */
    public function execute()
    {
        $this->manager->deleteExpire();
        $this->updateLastClean();
    }

    /**
     * Update last clean field
     *
     * @return void
     */
    protected function updateLastClean()
    {
        $this->configWriter->save(
            self::XML_CONFIG_LAST_CLEAN,
            $this->localeDate->formatDate()
        );
    }
}
