<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lead extends Model
{
  protected $primaryKey = 'id';
  protected $keyType = 'string';
  public $incrementing = false;

  protected static function boot()
  {
      parent::boot();
      static::creating(function (Model $model) {
          $model->setAttribute($model->getKeyName(), Str::uuid());
      });
  }

  public function setNameAttribute($value) {
    $this->attributes['name'] = Str::title($value);
  }


  public function funnel()
  {
    return $this->belongsTo('App\Funnel');
  }

  public function team()
  {
    return $this->belongsTo('App\Team');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function historics()
  {
    return $this->hasMany('App\LeadHistoric')->orderByDesc('created_at')->with(['user']);
  }
}
