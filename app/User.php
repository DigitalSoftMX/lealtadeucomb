<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\Catalogos\Empresas;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_surname', 'second_surname', 'username', 'email', 'password', 'sex', 'phone', 'image','active'
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
     * Get the path to the profile picture
     *
     * @return string
     */
    public function profilePicture()
    {
        /*if ($this->picture) {
            return "/storage/app/logo/{$this->picture}";
        }*/
        $id = \Auth::user()->id;
        $imagen = Empresas::where('id_user', '=', $id)->value('imglogo');

        return $imagen;
    }

   }
