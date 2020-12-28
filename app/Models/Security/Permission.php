<?php

namespace App\Models\Security;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends EntrustPermission
{
    use SoftDeletes;
    protected $table= 'permissions';
    protected $fillable = ['permission_id', 'role_id'];
    protected $dates = ['deleted_at'];
}
