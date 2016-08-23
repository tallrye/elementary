<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notifications\NotificationType;
use App\User;

class Notification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'description', 'notificationType_id', 'importance', 'isRead', 'action_name', 'action_link'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'user_id' => 'required',
        'notificationType_id' => 'required',
    );

    /**
     * Relationship between notifications and notification types.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
	{
		return $this->belongsTo(NotificationType::class, 'notificationType_id');
	}

    /**
     * Relationship between notifications and users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
