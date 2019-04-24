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
        return $this->calculateRawTime($this->timers);
    }

    /**
     * gets the total time for all Billable timers that are active
     *
     * @return float
     */
    public function getAllBillableTimeAttribute()
    {
        return $this->calculateRawTime(
            $this->timers()
                ->billable()
                ->whereHas('project', function ($query) {
                    $query->where('active', true);
                })
                ->get()
        );
    }

    /**
     * gets the total time for all Non-Billable timers
     *
     * @return float
     */
    public function getAllNonBillableTimeAttribute()
    {
        return $this->calculateRawTime(
            $this->non_billable_timers
        );
    }

    /**
     * gets the total time for all Non-Billable timers
     *
     * @return float
     */
    public function getAllBilledTimeAttribute()
    {
        return $this->calculateRawTime(
            $this->billed_timers
        );
    }

    /**
     * gets all timers that are non billable
     *
     * @return Collection
     */
    public function getNonBillableTimersAttribute()
    {
        return $this->timers()->nonBillable()->get();
    }

    /**
     * gets all timers that are billable and have been billed
     *
     * @return Collection
     */
    public function getBilledTimersAttribute()
    {
        return $this->timers()->billable()->billed()->get();
    }

    /**
     * gets all timers that are billable and have not been billed
     *
     * @return Collection
     */
    public function getNonBilledTimersAttribute()
    {
        return $this->timers()->billable()->notBilled()->get();
    }

    /**
     * calculateRawTime
     *
     * @param Collection $timers
     * @return float
     */
    protected function calculateRawTime($timers)
    {
        $time = 0;
        foreach ($timers as $timer) {
            $time += $timer->getTotalRawTime();
        }
        return round($time, 1);
    }
}
