<?php

namespace App\Filters;

class ClientFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    public $filters = ['active', 'inactive'];

    /**
     * The key being used in the session to store the filters
     *
     * @var string
     */
    public $sessionKey = 'clients';

    /**
     * construct the session key name
     *
     * @return void
     */
    protected function getSessionKeyName()
    {
        return 'filters.' . $this->sessionKey;
    }

    /**
     * Filter the query by clients that are active
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function active()
    {
        return $this->builder->where('active', true);
    }

    /**
     * Filter the query by clients that are inactive
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function inactive()
    {
        return $this->builder->where('active', false);
    }
}
