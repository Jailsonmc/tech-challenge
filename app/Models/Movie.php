<?php

namespace App\Models;

use App\Models\Traits\PrimaryAsUuid;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use PrimaryAsUuid;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
	    'year',
	    'synopsis',
	    'runtime',
	    'released_at',
	    'cost',
        'genre',
    ];

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function actorRoles(){
        return $this->hasMany(ActorRole::class, 'actor_id', 'id');
    }

}
