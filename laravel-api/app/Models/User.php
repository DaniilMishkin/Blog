<?php

namespace App\Models;

use App\Enums\AttachmentTypeEnum;
use App\Notifications\Auth\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'avatar_url',
        'about',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function likes(): HasMany
    {
        return  $this->hasMany(Like::class);
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable')
            ->where('type', AttachmentTypeEnum::USER_AVATAR);
    }

    public function subscribers()
    {
        return $this->belongsToMany(
            User::class,
            'subscribers',
            'subscriber_id',
            'user_id'
        );
    }

    public function subscriptions()
    {
        return $this->belongsToMany(
            User::class,
            'subscribers',
            'user_id',
            'subscriber_id'
        );
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getSubscriptionsCountAttribute()
    {
        return $this->subscriptions()->count();
    }

    public function getSubscribersCountAttribute()
    {
        return $this->subscribers()->count();
    }

    public function getIsFollowingAttribute()
    {
        return $this->subscribers()
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function scopeSort($query, $sort)
    {
        if (isset($sort['sort_by_subscriptions_count'])) {
            $query->withCount('subscriptions')
                ->orderBy('subscriptions_count', $sort['sort_by_subscriptions_count']);
        }

        return $query;
    }

    public function scopeFilter($query, $search)
    {
        if (isset($search['search'])) {
            $query->where('first_name', 'like', '%'.$search['search'].'%')
                ->orWhere('last_name', 'like', '%'.$search['search'].'%');
        }

        return $query;
    }
}
