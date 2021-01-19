<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class account_acount extends Authenticatable implements JWTSubject
{   use Notifiable;
    protected $table = 'tbl_account_account';
    protected $fillable = ['id',
                            'id_type',
                            'id_business',
                            'account_username',
                            'account_password',
                            'account_fullname',
                            'account_email',
                            'account_phone',
                            'account_status',
                            'force_sign_out'
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function getrole($role)
    {
        $r= DB::table('tbl_account_account')
        ->join('tbl_account_authorize','tbl_account_authorize.id_admin','=','tbl_account_account.id')
        ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
        ->where('tbl_account_authorize.id_admin',$this->id)
        ->where('tbl_account_permission.permission',$role)
        ->where('tbl_account_account.account_status','Y')
        ->where('tbl_account_account.id_business',$this->id_business)
        ->get();
        if(count($r)>0)
            return true;
    }
    public function get_type()
    {
        $type=DB::table('tbl_account_account')
        ->join('tbl_account_type','tbl_account_type.id','=','tbl_account_account.id_type')
        ->select('tbl_account_type.type_account','tbl_account_account.account_status')
        ->where('tbl_account_account.id',$this->id)
        ->where('tbl_account_account.id_business',$this->id_business)
        ->get();
        return $type;
    }
    public function getAuthPassword()
    {
        return $this->account_password;
    }
    public function get_all_account($id_store)
    {
        $acc=DB::table('tbl_account_account')
        ->join('tbl_account_type','tbl_account_type.id','=','tbl_account_account.id_type')
        ->select('tbl_account_account.id',
        'tbl_account_account.account_username',
        'tbl_account_account.account_fullname',
        'tbl_account_account.account_phone',
        'tbl_account_account.account_status',
        'tbl_account_type.id as id_type',
        'tbl_account_type.type_account',
        'tbl_account_type.description')
        ->where('tbl_account_account.id_business',$id_store)
        ->get();
        return $acc;
    }
    public function get_permission($id)
    {
        $idbussiness=Auth::user()->id_business;
        $acc=DB::table('tbl_account_authorize')
        ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
        ->where('tbl_account_authorize.id_admin',$id)
        ->where('tbl_account_authorize.id_business',$idbussiness)
        ->get();
        return $acc;
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
