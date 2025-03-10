<?php

namespace Modules\Chat\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class LiveChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        "live_chat_id",
        "from_user",
        "message",
        "file",
    ];

    protected $casts = [
        "message" => "json",
        "created_at" => "datetime",
        "updated_at" => "datetime",
        "is_seen" => "integer"
    ];

    public function liveChat(): BelongsTo
    {
        return $this->belongsTo(LiveChat::class,"live_chat_id","id");
    }

    public function user(): HasManyThrough
    {
        return $this->hasManyThrough(User::class,LiveChat::class,'live_chat_id','id','id','user_id');
    }

    public function member(): HasManyThrough
    {
        return $this->hasManyThrough(User::class,LiveChat::class,'live_chat_id','id','id','member_id');
    }

    // this method will be return file path
    public function getFilePathAttribute(){
        return $this->file;
    }

}
