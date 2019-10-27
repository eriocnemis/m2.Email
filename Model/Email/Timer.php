<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

/**
 * Timer
 */
class Timer
{
    /**
     * Start time
     *
     * @var float
     */
    protected $start;

    /**
     * Stop time
     *
     * @var float
     */
    protected $stop;

    /**
     * Start timer
     *
     * @return void
     */
    public function start()
    {
        $this->start = microtime(true);
    }

    /**
     * Stop timer
     *
     * @return void
     */
    public function stop()
    {
        $this->stop = microtime(true);
    }

    /**
     * Retrieve timer data
     *
     * @return float
     */
    public function get()
    {
        return $this->stop - $this->start;
    }
}
