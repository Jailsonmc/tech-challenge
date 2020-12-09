<?php

namespace App\Models;

use App\Models\Traits\PrimaryAsUuid;
use Illuminate\Database\Eloquent\Model;

class ActorRole extends Model
{
    use PrimaryAsUuid;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id_movie',
        'id_actor',
        'role'
    ];

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function actor(){
        return $this->belongsTo(Actor::class);
    }
}
