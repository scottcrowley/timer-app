<?php

namespace App\Filters;

class TimerFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    public $filters = ['billable', 'nonbillable', 'billed', 'notbilled'];

    /**
     * The key being used in the session to store the filters
     *
     * @var string
     */
    public $sessionKey = 'timers';

    /**
     * construct the session key name
     *
     * @return void
     */
    protected function getSessionKeyName()
    {
        return 'filters.' . $this->sessionKey . '.' . request()->route('project')->id;
    }

    /**
     * Filter the query by timers that are billable
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function billable()
    {
        return $this->builder->where('billable', true);
    }

    /**
     * Filter the query by timers that are non-billable
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function nonbillable()
    {
        return $this->builder->where('billable', false);
    }

    /**
     * Filter the query by timers that are billed
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function billed()
    {
        return $this->builder->where('billed', true);
    }

    /**
     * Filter the query by timers that are not billed
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function notbilled()
    {
        $this->builder = $this->billable();
        return $this->builder->where('billed', false);
    }
}
