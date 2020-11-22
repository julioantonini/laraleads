<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
          if (! $model->getKey()) {
            $model->{$model->getKeyName()} = (string) Str::orderedUuid();
          }
        });
    }



    protected $fillable = [
        'name', 'email','team_id','privilege_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function team()
    {
      return $this->belongsTo('App\Team');
    }

    public function privilege()
    {
      return $this->belongsTo('App\Privilege');
    }

    public function setPasswordAttribute($value) {
      $this->attributes['password'] = Hash::make($value);
    }

    public function setNameAttribute($value) {
      $this->attributes['name'] = Str::title($value);
    }

    public function leads()
    {
      return $this->hasMany('App\Lead');
    }
}
