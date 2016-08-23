<?php

namespace App\Models\Roles;

use App\Models\Roles\Role;
use App\Models\BaseModel;

class Permission extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'name' => 'required|unique:permissions',
        'description' => 'required',
    );
    /**
     * Relationship between permissions and roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
