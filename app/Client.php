<?php

namespace App;

use App\Filters\ClientFilters;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use ActiveStatus, TimerFunctions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * Get the projects associated with the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the all timers associated with the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function timers()
    {
        return $this->hasManyThrough(Timer::class, Project::class);
    }

    /**
     * Get the user belonging to the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * gets the count of all projects for this client
     *
     * @return void
     */
    public function getProjectCountAttribute()
    {
        return $this->projects->count();
    }

    /**
     * gets the count of only active projects for this client
     *
     * @return void
     */
    public function getActiveProjectCountAttribute()
    {
        return $this->projects()->active()->count();
    }

    /**
     * Apply all relevant client filters.
     *
     * @param  Builder       $query
     * @param  ClientFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ClientFilters $filters)
    {
        return $filters->apply($query);
    }
}
