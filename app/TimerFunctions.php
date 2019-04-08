<?php

namespace App;

trait TimerFunctions
{
    /**
     * gets the total time for All timers
     *
     * @return float
     */
    public function getAllTimeAttribute()
    {
        $time = 0;

        foreach ($this->timers as $timer) {
            $time += $timer->getTotalRawTime();
        }

        return round($time, 1);
    }

    /**
     * gets the total time for all Billable timers
     *
     * @return float
     */
    public function getAllBillableTimeAttribute()
    {
        $time = 0;
        $timers = $this->timers->where('billable', true);

        foreach ($timers as $timer) {
            $time += $timer->getTotalRawTime();
        }

        return round($time, 1);
    }

    /**
     * gets the total time for all Non-Billable timers
     *
     * @return float
     */
    public function getAllNonBillableTimeAttribute()
    {
        $time = 0;
        $timers = $this->timers->where('billable', false);

        foreach ($timers as $timer) {
            $time += $timer->getTotalRawTime();
        }

        return round($time, 1);
    }

    /**
     * gets all timers that are billable and have been billed
     *
     * @return collection
     */
    public function getBilledTimersAttribute()
    {
        return $this->timers->where('billable', true)->where('billed', true);
    }

    /**
     * gets all timers that are billable and have not been billed
     *
     * @return collection
     */
    public function getNonBilledTimersAttribute()
    {
        return $this->timers->where('billable', true)->where('billed', false);
    }
}
