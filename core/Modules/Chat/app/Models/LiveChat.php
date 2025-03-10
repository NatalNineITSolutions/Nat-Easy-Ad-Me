<?php

namespace Modules\Chat\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LiveChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_id',
        'admin_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id","id");
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class,"member_id","id");
    }

    public function livechatMessage(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class,"live_chat_id","id");
    }

    public function member_unseen_msg(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class,"live_chat_id","id")
            ->where("live_chat_messages.from_user", 1)
            ->where("live_chat_messages.is_seen", 0);
    }

    public function user_unseen_msg(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class,"live_chat_id","id")
            ->where("live_chat_messages.from_user", 2)->where("live_chat_messages.is_seen", 0);
    }

}
