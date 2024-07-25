<?php

namespace App\Models;

use App\Constants\GlobalConst;
use Laravel\Passport\HasApiTokens;
use App\Models\ReferralLevelPackage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $appends = ['fullname','userImage','stringStatus','lastLogin','kycStringStatus'];
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ["id"];

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
        'id'                        => 'integer',
        'email_verified_at'         => 'datetime',
        'address'                   => 'object',
        'email_verified'            => 'boolean',
        'kyc_verified'              => 'integer',
        'two_factor_verified'       => 'boolean',
        'two_factor_status'         => 'boolean',
        'referral_id'               => 'string',
    ];

    public function scopeEmailUnverified($query)
    {
        return $query->where('email_verified', false);
    }

    public function modelGuardName() {
        return "web";
    }

    public function scopeEmailVerified($query) {
        return $query->where("email_verified",true);
    }

    public function scopeKycVerified($query) {
        return $query->where("kyc_verified",GlobalConst::VERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->whereNot('kyc_verified',GlobalConst::VERIFIED);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', false);
    }

    public function kyc()
    {
        return $this->hasOne(UserKycData::class);
    }

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function wallets()
    {
        return $this->hasMany(UserWallet::class);
    }

    public function defaultWallet() {

        $wallets = $this->wallets()->when($this->wallets->has("currency"), function($query) {
            return $query->whereHas('currency',function($query) {
                $query->where('code',"USD");
            })->first();
        })->first();

        return $wallets ?? [];
    }
    
    public function getUserImageAttribute() {
        $image = $this->image;

        if($image == null) {
            return files_asset_path('profile-default');
        }else if(filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }else {
            return files_asset_path("user-profile") . "/" . $image;
        }
    }

    public function passwordResets() {
        return $this->hasMany(UserPasswordReset::class,"user_id");
    }

    public function scopeGetSocial($query,$credentials) {
        return $query->where("email",$credentials);
    }

    public function getStringStatusAttribute() {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if($status == GlobalConst::ACTIVE) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => __("Active"),
            ];
        }else if($status == GlobalConst::BANNED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => __("Banned"),
            ];
        }
        return (object) $data;
    }

    public function getKycStringStatusAttribute() {
        $status = $this->kyc_verified;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if($status == GlobalConst::APPROVED) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => __("Verified"),
            ];
        }else if($status == GlobalConst::PENDING) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => __("Pending"),
            ];
        }else if($status == GlobalConst::REJECTED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => __("Rejected"),
            ];
        }else {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => __("Unverified"),
            ];
        }
        return (object) $data;
    }

    public function loginLogs(){
        return $this->hasMany(UserLoginLog::class);
    }

    public function getLastLoginAttribute() {
        if($this->loginLogs()->count() > 0) {
            return $this->loginLogs()->get()->last()->created_at->format("H:i A, d M Y");
        }

        return "N/A";
    }

    public function scopeSearch($query,$data) {
        return $query->where(function($q) use ($data) {
            $q->where("username","like","%".$data."%");
        })->orWhere("email","like","%".$data."%")->orWhere("full_mobile","like","%".$data."%");
    }

    public function scopeNotAuth($query) {
        return $query->whereNot("id",auth()->user()->id);
    }

    public function investPlans() {
        return $this->hasMany(UserHasInvestPlan::class);
    }

    public function referUsers() {
        return $this->hasMany(ReferredUser::class,'refer_user_id','id');
    }

    public function referLevel() {
        return $this->belongsTo(ReferralLevelPackage::class,'current_referral_level_id','id');
    }

    /**
     * Get next refer level (If current level is top, it's return false)
     * @return App\Models\ReferralLevelPackage $next_refer_level | false
     */
    public function nextReferLevel() {
        $current_refer_level = $this->referLevel;
        $default_refer_level = ReferralLevelPackage::default()->first();
        if(!$current_refer_level && $default_refer_level) {
            return ReferralLevelPackage::default()->first();
        }else if(!$current_refer_level && !$default_refer_level) {
            $first_level = ReferralLevelPackage::first();
            if(!$first_level) return false;
            return $first_level;
        }

        $next_refer_level = ReferralLevelPackage::where('id','>',$current_refer_level->id)->orderBy('id','asc')->first();
        if(!$next_refer_level) return false;
        return $next_refer_level;
    }

    public function earnedLevels() {
        return $this->hasMany(UserEarnReferralLevel::class,'user_id');
    }

}
