<?php

namespace App\Http\Controllers;

use App\Filters\ProjectFilters;

class ProjectsSessionController extends Controller
{
    use SessionController;

    /**
     * specific filters for this instance
     *
     * @var ProjectFilters
     */
    protected $filters;

    /**
     * model id of the required dependency
     *
     * @var int
     */
    protected $dependency;

    /**
     * Create a new ProjectsSessionController instance
     *
     * @param ProjectFilters $filters
     * @return void
     */
    public function __construct(ProjectFilters $filters)
    {
        $this->dependency = request()->route('client');
        $this->filters = $filters;
    }
}
