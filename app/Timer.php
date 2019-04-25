<?php

namespace App;

use App\Filters\TimerFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total_time', 
        'total_time_label', 
        'total_billable_time', 
        'total_billable_time_label', 
        'total_non_billable_time', 
        'total_non_billable_time_label', 
        'total_billed_time', 
        'total_billed_time_label', 
        'total_not_billed_time', 
        'total_not_billed_time_label'
    ];

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
     * gets the total time for the timer
     *
     * @return float
     */
    public function getTotalTimeAttribute()
    {
        return floatval($this->calculateTime());
    }

    /**
     * pluralizes the total_time attribute
     *
     * @return string
     */
    public function getTotalTimeLabelAttribute() 
    {
        return Str::plural('hour', $this->total_time);
    }

    /**
     * gets the total time for the timer if it is billable
     *
     * @return float
     */
    public function getTotalBillableTimeAttribute()
    {
        return ($this->billable) ? floatval($this->calculateTime()) : 0;
    }

    /**
     * pluralizes the total_billable_time attribute
     *
     * @return string
     */
    public function getTotalBillableTimeLabelAttribute() 
    {
        return Str::plural('hour', $this->total_billable_time);
    }

    /**
     * gets the total time for the timer if it is non-billable
     *
     * @return float
     */
    public function getTotalNonBillableTimeAttribute()
    {
        return (! $this->billable) ? floatval($this->calculateTime()) : 0;
    }

    /**
     * pluralizes the total_non_billable_time attribute
     *
     * @return string
     */
    public function getTotalNonBillableTimeLabelAttribute() 
    {
        return Str::plural('hour', $this->total_non_billable_time);
    }

    /**
     * gets the total time for the timer if it is billable and billed
     *
     * @return float
     */
    public function getTotalBilledTimeAttribute()
    {
        return ($this->billable && $this->billed) ? floatval($this->calculateTime()) : 0;
    }

    /**
     * pluralizes the total_billed_time attribute
     *
     * @return float
     */
    public function getTotalBilledTimeLabelAttribute()
    {
        return Str::plural('hour', $this->total_billed_time);
    }

    /**
     * gets the total time for the timer if it is billable and not yet billed
     *
     * @return float
     */
    public function getTotalNotBilledTimeAttribute()
    {
        return ($this->billable && ! $this->billed) ? floatval($this->calculateTime()) : 0;
    }

    /**
     * pluralizes the total_not_billed_time attribute
     *
     * @return float
     */
    public function getTotalNotBilledTimeLabelAttribute()
    {
        return Str::plural('hour', $this->total_not_billed_time);
    }

    /**
     * calculate to total time for the timer rounded to tenths place
     *
     * @return float
     */
    protected function calculateTime() 
    {
        return $this->start->diffInHours($this->end) +
            round(
                ($this->start->diffInMinutes($this->end) - ($this->start->diffInHours($this->end) * 60)) / 60,
                1
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
