<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chat\MessageNotification;
use App\Models\Chat\Conversation;
use App\User;

class Message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text', 'sender_id', 'recipient_id', 'isRead'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'sender_id' => 'required',
        'text' => 'required',
    );

    /**
     * Relationship between messages and notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversation()
    {
        return $this->hasMany(MessageNotification::class, 'message_id');
    }

    /**
     * Relationship between messages and users when user
     * is the sender.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


}
