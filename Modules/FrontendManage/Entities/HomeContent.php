<?php

namespace Modules\FrontendManage\Entities;

use App\Traits\Tenantable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Translatable\HasTranslations;

class HomeContent extends Model
{
    use Tenantable;

    protected $fillable = [];

    use HasTranslations;

    public $translatable = ['value'];

//    public static function boot()
//    {
//        if (function_exists('SaasDomain')) {
//            $domain = SaasDomain();
//        } else {
//            $domain = 'main';
//        }
//        parent::boot();
//        self::created(function ($model) use ($domain) {
//
//            GenerateHomeContent($domain);
//        });
//        self::updated(function ($model) use ($domain) {
//            GenerateHomeContent($domain);
//        });
//    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('home_contents_');
            }
        });
        self::updated(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('home_contents_');
            }
        });
        self::deleted(function ($model) {
            if (function_exists('clearAllLangCache')) {
                clearAllLangCache('home_contents_');
            }
        });
    }

}
