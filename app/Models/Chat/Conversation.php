<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chat\MessageNotification;
use App\Models\Chat\Conversation;

class Conversation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender_id', 'recipient_id'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'sender_id' => 'required',
        'recipient_id' => 'required',
    );

    /**
     * Relationship between conversations and notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
	{
		return $this->HasMany(MessageNotification::class, 'conversation_id');
	}

    /**
     * Relationship between covnersations and users when user
     * is the sender.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship between covnersations and users when user
     * is the recipient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

}
