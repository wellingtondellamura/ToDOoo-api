<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'color', 'user_id', 'icon'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
