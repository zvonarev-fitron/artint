<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['user_id','order', 'fio', 'city', 'address', 'coord_w', 'coord_l'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
