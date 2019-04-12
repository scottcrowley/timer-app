<?php

namespace App\Filters;

class TimerFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['billable', 'nonbillable', 'billed', 'notbilled'];

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
