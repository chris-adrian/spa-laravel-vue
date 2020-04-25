<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileExtension extends Model
{
    // protected  $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dob','address','nationality','religion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token', 'type',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
