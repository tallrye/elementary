<?php

namespace App;

use App\Models\BaseModel;
use App\Profile;

class UserServer extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'userServers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['address', 'profile_id'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'address' => 'required',
        'profile_id' => 'required',
    );

    /**
     * Relationship between servers and profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
	{
		return $this->belongsTo(Profile::class, 'profile_id');
	}
}
