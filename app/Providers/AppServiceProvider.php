<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        //get sections status hide show
        $setting = Settings::first();
        $front_sections = $setting->sections_status ? json_decode($setting->sections_status,true) : null ;
        $sections = ['blog','blog_en','journals','add_research','international_publishing','international_conference'];
        if(!$front_sections){
                $new_sections = [];
                foreach($sections as $section){
                    $new_sections[$section] = 1;
                }
                $setting->sections_status = json_encode($new_sections);
                $setting->save();
                $front_sections = $new_sections;
        }
        view()->share('front_sections',$front_sections);
    }
}
