<?php

namespace App\Filters;

class ProjectFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['active', 'inactive'];

    /**
     * Filter the query by projects that are active
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function active()
    {
        return $this->builder->where('active', true);
    }

    /**
     * Filter the query by projects that are inactive
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function inactive()
    {
        return $this->builder->where('active', false);
    }
}
