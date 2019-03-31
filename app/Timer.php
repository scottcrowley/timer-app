<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'billable' => 'boolean',
        'billed' => 'boolean',
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    /**
     * The relationships to always eager load
     *
     * @var array
     */
    protected $with = ['project'];

    /**
     * Get the project belonging to the timer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Gets the Client associated with the Timer Project
     *
     * @return App\Client
     */
    public function getClient()
    {
        return $this->project->client;
    }

    /**
     * Gets the User associated with the Timer Project Client
     *
     * @return App\User
     */
    public function getUser()
    {
        return $this->project->client->user;
    }
}
