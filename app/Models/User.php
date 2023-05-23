<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    static public function CreateUsuario(array $array)
    {
        $new = new User();
        $new->name = $array['name'];
        $new->email = $array['email'];
        $new->password = bcrypt($array['password']);
        $new->save();
        return $new;
    }

    static public function UpdateUsuario($id, array $array)
    {
        $user = User::find($id);
        $user->name = $array['name'];
        $user->email = $array['email'];
        $user->password = bcrypt($array['password']);
        $user->save();
        return $user;
    }

    static public function DeleteUsuario($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    static public function GetUsuarios($attribute, $order, $paginate)
    {
        $users = User::where('name', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('email', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $users;
    }

    static public function GetUsuario($id)
    {
        $user = User::find($id);
        return $user;
    }
}
