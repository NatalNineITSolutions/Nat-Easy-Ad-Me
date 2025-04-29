<?php

namespace App\Models;

use App\Models\Backend\IdentityVerification;
use App\Models\Backend\Listing;
use App\Models\UserPayoutDetail;
use App\Models\Frontend\AccountDeactivate;
use App\Models\Frontend\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Chat\app\Models\LiveChat;
use Modules\Chat\app\Models\LiveChatMessage;
use Modules\CountryManage\app\Models\City;
use Modules\CountryManage\app\Models\Country;
use Modules\CountryManage\app\Models\State;
use Modules\Membership\app\Models\MembershipHistory;
use Modules\Membership\app\Models\UserMembership;
use App\Models\UsersBV;
use Modules\Wallet\app\Models\Wallet;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes, NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'partner_id',
        'partner_name',
        'first_name',
        'last_name',
        'username',
        'phone',
        'email',
        'password',
        'image',
        'profile_background',
        'country_id',
        'state_id',
        'city_id',
        'post_code',
        'latitude',
        'longitude',
        'address',
        'about',
        'terms_condition',
        'google_id',
        'facebook_id',
        'apple_id',
        'email_verify_token',
        'email_verified',
        'otp_verified',
        'check_online_status',
        'verified_status',
        'is_suspend',
        'status',
        'user_code',
        'parent_id',
        'bv_points',
        'position',
        'membership_id',
        'bv_points',
        'profile_completed',
        'gender',
        'dob',
        'referral_commission',
        'sponsor_id',
        'placement_id',
        'deleted_at',
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
        'password' => 'hashed',
        'check_online_status' => 'datetime',
        'partner_id' => 'string',
    ];

    //get user full name
    public function getFullnameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user_country()
    {
        return $this->belongsTo(Country::class, 'country_id')->select('id', 'country', 'status');
    }
    public function user_state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function user_city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function identity_verify()
    {
        return $this->hasOne(IdentityVerification::class, 'user_id', 'id');
    }
    public function user_wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function membershipUser()
    {
        if (!moduleExists('Membership')) {
            return null;
        }
        return $this->hasOne(UserMembership::class, 'user_id', 'id');
    }

    public function adsMembership()
    {
        return $this->hasOne(UserMembership::class, 'user_id', 'id')
            ->whereRelation('membership', 'category', 0);
    }


    public function listings()
    {
        return $this->hasMany(Listing::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }
    public function account_deactivates()
    {
        return $this->hasMany(AccountDeactivate::class, 'user_id', 'id');
    }

    public function member_unseen_message()
    {
        if (moduleExists('Chat')) {
            return $this->hasManyThrough(LiveChatMessage::class, LiveChat::class, 'member_id', 'live_chat_id');
        }
        return null;
    }

    public function user_unseen_message()
    {
        if (moduleExists('Chat')) {
            return $this->hasManyThrough(LiveChatMessage::class, LiveChat::class, 'user_id', 'live_chat_id');
        }
        return null;
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function userBvs()
    {
        return $this->hasMany(UsersBV::class);
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function allReferrals()
    {
        return $this->referrals()->with('allReferrals');
    }

    public function getMLMTree($userId)
    {
        $user = User::with('children')->find($userId);

        if (!$user) {
            return null;
        }

        $tree = [
            'id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'partner_id' => $user->partner_id,
            'children' => [],
        ];

        foreach ($user->children as $child) {
            $tree['children'][] = $this->getMLMTree($child->id);
        }

        return $tree;
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function leftChild()
    {
        return $this->hasOne(User::class, 'parent_id')->where('position', 'left');
    }

    public function rightChild()
    {
        return $this->hasOne(User::class, 'parent_id')->where('position', 'right');
    }

    public function kyc()
    {
        return $this->hasOne(MatrimonyKyc::class, 'user_id');
    }

    public function matrimonyPreference()
    {
        return $this->hasOne(MatrimonyPreference::class, 'user_id');
    }

    public function profileListings()
    {
        return $this->hasMany(ProfileListing::class);
    }

    public function membershipHistory(): HasOne
    {
        return $this->hasOne(MembershipHistory::class)->latest();
    }

    public function sentRequests()
    {
        return $this->hasMany(ProfileRequest::class, 'sender_id');
    }

    public function receivedRequests()
    {
        return $this->hasManyThrough(
            ProfileRequest::class,
            ProfileListing::class,
            'user_id', // Foreign key on profile_listings table
            'profile_id', // Foreign key on profile_requests table
            'id', // Local key on users table
            'id' // Local key on profile_listings table
        );
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    // Recursive relationship
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function membership()
    {
        return $this->hasOne(UserMembership::class);
    }

    public function kycRecord()
    {
        return $this->hasOne(IdentityVerification::class);
    }

    public function payout_details()
    {
        return $this->hasOne(UserPayoutDetail::class)->latestOfMany();
    }
}
