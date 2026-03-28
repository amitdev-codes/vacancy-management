<?php

namespace App\Providers;

use App\Models\MstFiscalYear;
use App\Models\VacancyAd;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class GlobalStaticProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::rememberForever('fiscal_year_id', function () {
           return MstFiscalYear::where('is_current', false)->value('id');
        });

        Cache::rememberForever('file_promotion_type_settings', function () {
            $fiscal_year_id = MstFiscalYear::where('is_current', true)->value('id');
            return VacancyAd::where([['fiscal_year_id', $fiscal_year_id], ['is_deleted', false], ['is_published', true],['opening_type_id',3]])
                ->first(['id','ad_title_en', 'notice_no']);
        });
        Cache::rememberForever('internal_type_settings', function () {
            $fiscal_year_id = MstFiscalYear::where('is_current', true)->value('id');
            return VacancyAd::where([['fiscal_year_id', $fiscal_year_id], ['is_deleted', false], ['is_published', true],['opening_type_id',2]])
                ->first(['id','ad_title_en', 'notice_no']);
        });
        Cache::rememberForever('opening_type_settings', function () {
            $fiscal_year_id = MstFiscalYear::where('is_current', true)->value('id');
            return VacancyAd::where([['fiscal_year_id', $fiscal_year_id], ['is_deleted', false], ['is_published', true],['opening_type_id',1]])
                ->first(['id','ad_title_en', 'notice_no']);
        });
    }
}
