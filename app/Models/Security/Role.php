<?php

namespace App\Models\Security;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{
    use SoftDeletes;
    protected $table= 'roles';
    protected $dates = ['deleted_at'];
}
