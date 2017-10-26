<?php

namespace Code\User\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Code\Core\Model\AuthenticatableModel;

class User extends AuthenticatableModel
{
    use Notifiable, SoftDeletes;

    protected $show = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'facebook_id', 'google_id', 'twitter_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $columns = [
        [
            'name'  => 'Name',
            'index' => 'name'
        ],
        [
            'name'  => 'Email',
            'index' => 'email'
        ],
        [
            'name'  => 'Created On',
            'index' => 'created_at',
            'type'  => 'date'
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(){
        return $this->hasMany('Code\UserProduct\Model\UserProduct', 'user_id');
    }
}
