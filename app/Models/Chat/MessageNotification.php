<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chat\Message;
use App\Models\Chat\Conversation;

class MessageNotification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messageNotifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['conversation_id', 'message_id'];

    /**
     * The model's rules used for validation.
     *
     * @var array
     */
    public static $rules = array(
        'conversation_id' => 'required',
        'message_id' => 'required',
    );

    /**
     * Relationship between notifications and conversations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
	{
		return $this->belongsTo(Conversation::class, 'conversation_id');
	}

    /**
     * Relationship between notifications and messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

}
