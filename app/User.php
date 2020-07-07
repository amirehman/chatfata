<?php
// TCG\Voyager\Http\Controllers\VoyagerUserController
namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
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

    public function recipes()
    {
        return $this->hasMany(Recipe::class)->where('status', "PUBLISHED");
    }

    public function allrecipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function draftrecipes()
    {
        return $this->hasMany(Recipe::class)->where('status', "DRAFT");
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function application()
    {
        return $this->hasOne(ChannelApplication::class, 'user_id');
    }
    public function social()
    {
        return $this->hasmany(UserSocialmedia::class, 'user_id');
    }
    public function media()
    {
        return $this->hasmany(UserSocialmedia::class, 'user_id');
    }
}
