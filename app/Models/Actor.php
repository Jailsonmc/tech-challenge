<?php

namespace App\Models;

use App\Models\Traits\PrimaryAsUuid;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use PrimaryAsUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'bio',
        'born_at'
    ];
}
