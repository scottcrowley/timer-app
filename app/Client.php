<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id'
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
     * Check to see if active status is true
     *
     * @return void
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Toggles active status of the client. Returns new active status
     *
     * @return bool
     */
    public function toggleActive()
    {
        $response = ($this->active) ? $this->makeInactive() : $this->makeActive();

        return ! $this->active;
    }

    /**
     * Make the client inactive
     *
     * @return bool
     */
    protected function makeInactive()
    {
        if ($this->active) {
            $this->active = false;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Make the client active
     *
     * @return bool
     */
    protected function makeActive()
    {
        if (! $this->active) {
            $this->active = true;
            $this->save();
            return true;
        }
        return false;
    }
}
