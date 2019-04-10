<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::where('user_id', auth()->id())->orderBy('name')->get();

        if (request()->expectsJson()) {
            return response($clients);
        }

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $data['user_id'] = auth()->id();

        $client = Client::create($data);

        session()->flash('flash', ['message' => 'The Client added successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($client, 201);
        }

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $this->authorize('update', $client);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $data = $request->validate([
            'name' => 'required',
            'active' => 'boolean'
        ]);

        $response = $client->update($data);

        session()->flash('flash', ['message' => 'The Client updated successfully!', 'level' => 'success']);

        if ($request->expectsJson()) {
            return response($response, 202);
        }

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $this->authorize('update', $client);

        $client->delete();

        session()->flash('flash', 'The Client was deleted successfully!');

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('clients.index'));
    }
}
