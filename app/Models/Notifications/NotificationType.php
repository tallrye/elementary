<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notifications\Notification;

class NotificationType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notificationTypes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'icon'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'name' => 'required',
    );

    /**
     * Relationship between notification types and notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
	{
		return $this->hasMany(Notification::class, 'notificationType_id');
	}

}
