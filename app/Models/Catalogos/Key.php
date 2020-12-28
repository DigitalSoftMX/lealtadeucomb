<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    public $timestamps = true;
    protected $table = 'keys';
    protected $fillable = ['id', 'publickey', 'privatekey'];
}
