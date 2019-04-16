<?php

namespace App\Http\Controllers;

use App\Filters\TimerFilters;

class TimersSessionController extends Controller
{
    use SessionController;

    /**
     * specific filters for this instance
     *
     * @var TimerFilters
     */
    protected $filters;

    /**
     * model id of the required dependency
     *
     * @var int
     */
    protected $dependency;

    /**
     * Create a new TimersSessionController instance
     *
     * @param TimerFilters $filters
     * @return void
     */
    public function __construct(TimerFilters $filters)
    {
        $this->dependency = request()->route('project');
        $this->filters = $filters;
    }
}
