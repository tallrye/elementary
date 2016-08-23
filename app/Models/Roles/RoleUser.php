<?php

namespace App\Models\Roles;

use App\User;
use App\Models\Roles\Role;
use App\Models\BaseModel;

class RoleUser extends BaseModel
{

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'role_user';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'user_id'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
 	public static $rules = array(
        'role_id' => 'required',
        'user_id' => 'required',
    );

 	/**
     * Relationship between role_user pivot table and roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function role()
	{
		return $this->belongsTo(Role::class, 'role_id');
	}

    /**
     * Relationship between role_user pivot table and users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

