<?php

namespace App\Policies;

use App\User;
use App\Client;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $requestClient = request()->route('client');
        $client = ($requestClient instanceof Client) ? $requestClient : Client::findOrFail($requestClient);

        return ($client->user_id == $user->id);
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return ($project->client->user_id == $user->id);
    }
}
