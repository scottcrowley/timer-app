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
     * Gets the User associated with the Project's Client
     *
     * @return App\User
     */
    public function getUser()
    {
        return $this->client->user;
    }
}
