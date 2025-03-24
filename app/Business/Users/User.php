<?php

namespace App\Business\Users;

use App\Tools\Jwt;
use App\Business\Orders\Order;
use App\Business\AbstractModel;
use App\Business\NftsUser\NftsUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Business\UserWallet\UserWallet;
use App\Business\KeyAddress\KeyAddress;
use App\Business\UserAvatar\UserAvatar;
use App\Business\UserFriend\UserFriend;
use App\Business\Transaction\Transaction;
use App\Business\DynamicLink\DynamicLinks;
use App\Business\LivaaCoinOrder\LivaaCoinOrder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Business\Country\Country;
use App\Business\Category\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Business\DashboardBusiness\DashboardBusiness;
use App\Business\MintedLand\MintedLand;
use App\Business\Invite\Invite;

class User  extends AbstractModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;

    protected $table = 'users';
    protected $guarded = [];
    protected $appends = [];
    private static $id_types = ['passport', 'license', 'personal_identification'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'remember_token',
        'email_verified_at',
        'score',
        //      'deleted_at'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $translatable = [];
    public $timestamps = true;
    public $softDeleting = true;

    protected $fillable = [
        'id',
        'email',
        'name',
        'company_name',
        'logo',
        'avatar_logo',
        'is_blockchain',
        'password',
        'salt',
        'activated',
        'otp_code',
        'national_number',
        'image',
        'birthday',
        'gender',
        'country_id',
        'user_name',
        'mobile',
        'id_type',
        'id_type_documet',
        'user_type', // b2c - b2b - employee
        'company_registration_document',
        'authorized_person_name',
        'moa_document',
        'confirmation_otp_sms',
        'admin_business_approval',
        'make_action',
        'category_id',
        'is_vip',
        'kyc_submitted',
        'is_block'
    ];

    protected function token(): Attribute
    {
        return new Attribute(
            get: fn ($token) => Jwt::getJwtToken($this->id),
        );
    }

    public static function getIdType($index = null): string
    {
        return self::$id_types[$index];
    }

    protected function password(): Attribute
    {
        return new Attribute(
            set: fn ($password) => Hash::make($password),
        );
    }


    public function dynamiclink()
    {
        return $this->hasMany(DynamicLinks::class);
    }

    public function publicaddress()
    {
        return $this->hasMany(KeyAddress::class);
    }

    public function wallet()
    {
        return $this->hasOne(UserWallet::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function avatar()
    {
        return $this->hasMany(UserAvatar::class);
    }

    public function avatarByType()
    {
        return $this->hasMany(UserAvatar::class)->where('type', 1);
    }

    public function livaaCoinOrder()
    {
        return $this->hasMany(LivaaCoinOrder::class);
    }

    public function lands()
    {
        return $this->hasMany(MintedLand::class);
    }


    /*
    public function GroupedTransactions(){
        return $this->transactions();
    }*/

    public function paymentsByStatus($status = 'SUCCESS')
    {
        return $this->payments()->where('status', $status);
    }

    public function nftsuser()
    {
        return $this->hasMany(NftsUser::class);
    }

    public function nftsCountByNftId($nft_id)
    {
        return $this->hasMany(NftsUser::class)->where('nfts_users.nft_id', $nft_id)->count();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function friend()
    {
        return $this->hasMany(UserFriend::class);
    }

    // this is field businies for B2B profile
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dashboardBusiness()
    {
        return $this->hasOne(DashboardBusiness::class);
    }

    public function invites()
    {
        return $this->hasMany(Invite::class, 'owner_user_id', 'id');
    }
}
