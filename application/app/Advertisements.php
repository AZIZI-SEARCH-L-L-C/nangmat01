<?php

namespace AziziSearchEngineStarter;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Carbon\Carbon;

class Advertisements extends Model
{
	use SearchableTrait;
	
    protected $table = 'ads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id', 
		'title', 
		'keywords', 
		'description', 
		'url', 
		'Vurl', 
		'turn', 
		'approved', 
		'impressions',
		'clicks',
		'budget',
		'paid',
	];
	
	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'clicks', 
		'impressions', 
		'url',
		'approved',
		'turn',
		'relevance',
		'package_id',
		'compain_id',
		'created_at',
		'updated_at',
		'target',
		'paid',
		'compain',
		'user',
    ];
	
	protected $searchable = [
        'columns' => [
            'title' => 10,
            'keywords' => 9,
            'description' => 8,
            'url' => 7,
            // 'Vurl' => 3,
        ]
    ];
	
	public function target(){
		return $this->hasOne('AziziSearchEngineStarter\AdTargets', 'ad_id');
	}
	
	public function compain(){
		return $this->belongsTo('AziziSearchEngineStarter\AdsCompain', 'compain_id');
	}
	
	public function user(){
		return $this->belongsTo('AziziSearchEngineStarter\User', 'user_id');
	}
	
	/**
     * @return bool
     */
    public function oneImpression(){
		if($this->type == 1){
			$newPaid = $this->paid + $this->costPer;
			$this->update(['paid' => $newPaid]);
			if(!$this->useBudget){
				$newPaid2 = $this->user->credit - $this->costPer;
				$this->user->update(['credit' => $newPaid2]);
			}else{
				$this->chargeUserIfUnsFu();
			}
		}
		return $this->update(['impressions' => $this->impressions + 1]);
    }
	
	/**
     * @return bool
     */
    public function oneClick(){
		if($this->type == 0){
			$newCredit = $this->paid + $this->costPer;
			$this->update(['paid' => $newCredit]);
			if(!$this->useBudget){
				$newPaid2 = $this->user->credit - $this->costPer;
				$this->user->update(['credit' => $newPaid2]);
			}else{
				$this->chargeUserIfUnsFu();
			}
		}
		return $this->update(['clicks' => $this->clicks + 1]);
    }
	
	/**
     * @return bool
     */
    public function oneDay(){
		if($this->type == 2){
			$start_at = Carbon::parse($this->created_at);
			$now = Carbon::now();
			$lengthOfAd = $start_at->diffInDays($now) + 1;
			$newCredit = $lengthOfAd * $this->costPer;
			$this->update(['paid' => $newCredit]);
			return true;
		}
		return false;
    }
	
	protected function chargeUserIfUnsFu(){
		if($this->paid > $this->budget){
			$cost = $this->budget - $this->paid;
			$newCredit = $this->user->credit + $cost;
			$this->user->update(['credit' => $newCredit]);
		}
	}
	
    /**
     * @return bool
     */
    public function resetImpressions(){
        return $this->update(['impressions' => 0]);
    }
	
    /**
     * @return bool
     */
    public function resetClicks(){
        return $this->update(['clicks' => 0]);
    }
	
    /**
     * @return bool
     */
    public function turnOff(){
        return $this->update(['turn' => 0]);
    }
	
    /**
     * @return bool
     */
    public function turnOn(){
        return $this->update(['turn' => 1]);
    }
	
    /**
     * @return bool
     */
    public function approve(){
        return $this->update(['approved' => 1]);
    }
	
    /**
     * @return bool
     */
    public function unApprove(){
        return $this->update(['approved' => 0]);
    }
	
	/**
     * tfi ad ila kan sold 9al mn ad cost.
     * @return void
     */
    public function turnOffUnSufficientFunds(){
		if($this->useBudget){
			$remain = $this->budget - $this->paid;
		}else{
			$remain = $this->user->credit;
		}
		$now = Carbon::now();
		$ends = Carbon::parse($this->target->end);
		if($now->gt($ends) || ($this->costPer > $remain)){
			// finish payment issue
			$this->turnOff();
			return true;
		}
		return false;
    }
	
	/**
     * 
     * @return boolean
     */
	private function periodExpired(){
		$end_at = Carbon::parse($this->created_at)
			    ->addDays($this->package->value);
		$expire = strtotime($end_at) - time();
		return $expire > 0 ? false : true;
	}
	
	
    public function getURL(){
		// make it with route
		$cofi = str_random(500);
		$timestamp = Carbon::now()->timestamp;
        return route('ad.redirect', ['te' => $timestamp, 'co' => $cofi, 's' => $this->slug]);
    }
	
	
	
	
	
	// ---------------------------- for ads with images
	
	/**
     * @param string $extension
     * @return string
     */
    public static function generateImageName($extension = 'png'){
        return Carbon::now()->timestamp.'_'.str_random(8).'.'.$extension;
    }
	
	/**
     * @param UploadedFile $file
     */
    public function saveImage(UploadedFile $file){
        $this->deleteImage();
        $image = Image::make($file);
        $image_name = Advert::generateImageName();
        // $advert_category = $this->advert_category;
        // $width = $advert_category->width?$advert_category->width:null;
        // $height = $advert_category->height?$advert_category->height:null;
        // if($advert_category->width === null || $advert_category->height === null){
            // $image->resize($advert_category->width, $advert_category->height, function ($constraint) {
                // $constraint->aspectRatio();
            // });
        // } else {
            // $image->resize($advert_category->width, $advert_category->height);
        // }
		$userId = $this->compain->user->id;
		$path = storage_path('uploads' . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $image_name);
        $image->save($path);
        $this->update(['image' => $path]);
    }
	
	/**
     *
     */
    private function deleteImage(){
        if(Storage::exists($this->image) && $this->image !== null){
            Storage::delete($this->image);
        }
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($ad) { // before delete() method call this
            $ad->target()->delete();
        });
    }

}
