<?php

namespace App\Models\Roles;

use App\Models\BaseModel;

class PermissionRole extends BaseModel
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'permission_role';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['permission_id', 'role_id'];
}
