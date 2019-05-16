<?php

namespace App\Policies;

use App\User;
use App\Timer;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create timers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $requestProject = request()->route('project');
        $project = $requestProject instanceof Project ? $requestProject : Project::findOrFail($requestProject);

        return $project->client->user_id == $user->id;
    }

    /**
     * Determine whether the user can update the timer.
     *
     * @param  \App\User  $user
     * @param  \App\Timer  $timer
     * @return mixed
     */
    public function update(User $user, Timer $timer)
    {
        return $timer->project->client->user_id == $user->id;
    }
}
