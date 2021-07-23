<?php
namespace AziziSearchEngineStarter;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable, EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
		'email', 
		'password', 
		'admin',
		'confirmed',
		'confirmation_key',
		'references',
		'credit',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	// for admin Auth
	public function isAdmin(){
		return $this->admin; // this looks for an admin column in your users table
	}
	
	/**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }
	
    public function getSearchReference($field)
    {
        $referneces = json_decode($this->references, true);
        if(!isset($referneces[$field])) return null;
		return $referneces[$field];
    }
	
	public function billing(){
        return $this->hasOne('AziziSearchEngineStarter\Billing', 'user_id');
    }
	
	public function payments(){
        return $this->hasMany('AziziSearchEngineStarter\Payments', 'user_id');
    }
	
	public function compains(){
        return $this->hasMany('AziziSearchEngineStarter\AdsCompain', 'user_id');
    }
	
	public function ads(){
        return $this->hasMany('AziziSearchEngineStarter\Advertisements', 'user_id');
    }

	public function bookmarksCats(){
        return $this->hasMany('AziziSearchEngineStarter\BookmarksCats', 'user_id');
    }

	public function bookmarks(){
        return $this->hasMany('AziziSearchEngineStarter\Bookmarks', 'user_id');
    }

	public function comments(){
        return $this->hasMany('AziziSearchEngineStarter\Comments', 'user_id');
    }
}
