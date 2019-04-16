<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait SessionController
{
    /**
     * store a new set of client filters to the session
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $key = $this->getSessionKey();

        $this->clear($key);

        $request->session()->put($key, $request->only($this->filters->filters));

        if (request()->wantsJson()) {
            return response(session()->get($key), 201);
        }
    }

    /**
     * clear the session of the filters
     *
     * @return void
     */
    protected function clear($key)
    {
        session()->forget($key);
    }

    /**
     * destroys the filters from the session
     *
     * @return void
     */
    public function destroy()
    {
        $this->clear($this->getSessionKey());

        if (request()->wantsJson()) {
            return response([], 204);
        }
    }

    /**
     * construct the session key name
     *
     * @return string
     */
    protected function getSessionKey()
    {
        $key = 'filters.' . $this->filters->sessionKey;
        if ($this->dependency) {
            $key .= '.' . $this->dependency;
        }
        return $key;
    }
}
