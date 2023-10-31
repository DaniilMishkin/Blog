<?php

namespace App\Models;

use App\Enums\AttachmentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'image_url',
        'likes_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable')
            ->where('type', AttachmentTypeEnum::POST_IMAGE);
    }

    public function getIsLikePressedAttribute()
    {
        return $this->likes()
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function scopeSort($query, $sort)
    {
        if (isset($sort['sort_by_date'])) {
            $query->orderBy('created_at', $sort['sort_by_date']);
        }

        if (isset($sort['sort_by_likes_count'])) {
            $query->orderBy('likes_count', $sort['sort_by_likes_count']);
        }

        return $query;
    }

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['search'])) {
            $query->where('title', 'like', '%'.$filter['search'].'%')
                ->orWhere('text', 'like', '%'.$filter['search'].'%');
        }

        if (isset($filter['user_news'])) {
            $subscriptionsIds = Auth::user()->subscriptions()
                ->pluck('subscriber_id');

            $subscriptionsIds->push(Auth::id());

            $query->whereIn('user_id', $subscriptionsIds);
        }

        if (isset($filter['filter_by_user_id'])) {
            $query->where('user_id', $filter['filter_by_user_id']);
        }

        return $query;
    }
}
