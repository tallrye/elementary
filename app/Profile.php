<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserServer;
use App\User;

class Profile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'photo', 'theme', 'sidebarOpen', 'title', 'organization', 'isBlocked', 'isActivationSent'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'email' => 'required|unique:profiles',
    );

    /**
     * Relationship between profiles and servers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers()
	{
		return $this->hasMany(UserServer::class, 'profile_id');
	}

    /**
     * Relationship between profiles and users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
	public function user()
    {
        return $this->hasOne(User::class, 'profile_id');
    }
}
