<?php

namespace App;

use App\Filters\ProjectFilters;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use ActiveStatus, TimerFunctions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'client_id', 'description', 'active'
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
     * Get the client belonging to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the timers associated with the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timers()
    {
        return $this->hasMany(Timer::class);
    }

    /**
     * Gets the User associated with the Project's Client
     *
     * @return App\User
     */
    public function getUser()
    {
        return $this->client->user;
    }

    /**
     * Apply all relevant project filters.
     *
     * @param  Builder       $query
     * @param  ProjectFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ProjectFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Active Projects
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
