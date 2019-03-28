<?php

namespace App;

trait ActiveStatus
{
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
     * Toggles active status of the model. Returns new active status
     *
     * @return bool
     */
    public function toggleActive()
    {
        $response = ($this->active) ? $this->makeInactive() : $this->makeActive();

        return ! $this->active;
    }

    /**
     * Make the model inactive
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
     * Make the model active
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
