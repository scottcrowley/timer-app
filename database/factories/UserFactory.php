<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'user_id' => function () {
            return factory(App\User::class);
        },
        'active' => true
    ];
});

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'description' => $faker->sentence(),
        'client_id' => function () {
            return factory(App\Client::class);
        },
        'active' => true
    ];
});

$factory->define(App\Timer::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(),
        'project_id' => function () {
            return factory(App\Project::class);
        },
        'start' => now()->subHours(3)->toDateTimeString(),
        'end' => now()->toDateTimeString(),
        'billable' => true,
        'billed' => false
    ];
});
