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
}
