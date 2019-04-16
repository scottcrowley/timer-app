<?php

namespace App\Http\Controllers;

use App\Filters\ClientFilters;

class ClientsSessionController extends Controller
{
    use SessionController;

    /**
     * specific filters for this instance
     *
     * @var ClientFilters
     */
    protected $filters;

    /**
     * model id of the required dependency
     *
     * @var int
     */
    protected $dependency;

    /**
     * Create a new ClientsSessionController instance
     *
     * @param ClientFilters $filters
     * @return void
     */
    public function __construct(ClientFilters $filters)
    {
        $this->filters = $filters;
    }
}
