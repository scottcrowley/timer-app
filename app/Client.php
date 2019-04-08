<?php

namespace App;

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

    public function getProjectCountAttribute()
    {
        return $this->projects->count();
    }
}
