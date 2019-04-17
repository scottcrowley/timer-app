<?php

namespace App;

use App\Filters\TimerFilters;
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

    // /**
    //  * The relationships to always eager load
    //  *
    //  * @var array
    //  */
    // protected $with = ['project'];

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
     * Get the Client associated with the Timer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function client()
    {
        return $this->hasOneThrough(Client::class, Project::class, 'client_id', 'id');
    }

    /**
     * Get the User associated with the Timer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Client::class, 'user_id', 'id');
    }

    /**
     * gets the raw total time for the timer rounded to ten thousandths place
     *
     * @return float
     */
    public function getTotalRawTime()
    {
        return floatval(
            round($this->start->diffInMinutes($this->end) / 60, 5)
        );
    }

    /**
     * gets the total time for the timer rounded to tenths place
     *
     * @return float
     */
    public function getTotalTimeAttribute()
    {
        return floatval(
            $this->start->diffInHours($this->end) +
                round(
                    ($this->start->diffInMinutes($this->end) - ($this->start->diffInHours($this->end) * 60)) / 60,
                    1
                )
        );
    }

    /**
     * gets the billable status
     *
     * @return bool
     */
    public function getIsBillableAttribute()
    {
        return $this->billable;
    }

    /**
     * gets the billed status
     *
     * @return bool
     */
    public function getIsBilledAttribute()
    {
        return $this->billed;
    }

    /**
     * Apply all relevant timer filters.
     *
     * @param  Builder       $query
     * @param  ProjectFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, TimerFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * All billable timers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeBillable($query)
    {
        return $query->where('billable', true);
    }

    /**
     * All nonbillable timers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNonBillable($query)
    {
        return $query->where('billable', false);
    }

    /**
     * All billed timers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeBilled($query)
    {
        return $query->where('billed', true);
    }

    /**
     * All not billed timers
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeNotBilled($query)
    {
        return $query->where('billed', false);
    }
}
