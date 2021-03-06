<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();

        $this->actingAs($user);

        return $this;
    }

    protected function createProject($action = 'create', $attributes = [], $times = null, $user = null, $client = null)
    {
        if (is_null($user) && is_null($client)) {
            $this->signIn();
            $user = auth()->user();
        }

        if (is_null($client)) {
            $client = create('App\Client', ['user_id' => $user->id]);
        }

        return $action('App\Project', array_merge($attributes, ['client_id' => $client->id]), $times);
    }

    protected function createTimer($action = 'create', $attributes = [], $times = null, $user = null, $client = null, $project = null)
    {
        if (is_null($project)) {
            $project = $this->createProject('create', [], null, $user, $client);
        }

        return $action('App\Timer', array_merge($attributes, ['project_id' => $project->id]), $times);
    }
}
