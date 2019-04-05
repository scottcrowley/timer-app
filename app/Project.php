<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use ActiveStatus;

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
     * The relationships to always eager load
     *
     * @var array
     */
    protected $with = ['client'];

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
     * gets the total time for All timers
     *
     * @return float
     */
    public function getAllTimeAttribute()
    {
        $time = 0;

        foreach ($this->timers as $timer) {
            $time += $timer->getTotalRawTime();
        }

        return round($time, 1);
    }

    /**
     * gets the total time for all Billable timers
     *
     * @return float
     */
    public function getAllBillableTimeAttribute()
    {
        $time = 0;
        $timers = $this->timers->where('billable', true);

        foreach ($timers as $timer) {
            $time += $timer->getTotalRawTime();
        }

        return round($time, 1);
    }

    /**
     * gets the total time for all Non-Billable timers
     *
     * @return float
     */
    public function getAllNonBillableTimeAttribute()
    {
        $time = 0;
        $timers = $this->timers->where('billable', false);

        foreach ($timers as $timer) {
            $time += $timer->getTotalRawTime();
        }

        return round($time, 1);
    }

    /**
     * gets all timers that have been billed
     *
     * @return collection
     */
    public function getBilledTimersAttribute()
    {
        return $this->timers->where('billed', true);
    }

    /**
     * gets all timers that have not been billed
     *
     * @return collection
     */
    public function getNonBilledTimersAttribute()
    {
        return $this->timers->where('billed', false);
    }
}
