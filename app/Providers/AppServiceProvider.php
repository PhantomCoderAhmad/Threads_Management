<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Blade;
use Auth;
use Config;
use DB;
use Illuminate\Support\Facades\App;
use App\Models\Route;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Blog;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        view()->composer('*', function($view) {
            $parent_cat = DB::table("forum_categories")->select(DB::raw("*"))->where('parent_id' , null)->where('is_private' , 0)->get();
            $blog_category = Blog::select('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->unique('category');

            $recent_posts = Blog::orderBy('created_at', 'desc')->take(5)->get();
            $view->with(['parent_cat' => $parent_cat, 'blog_category' => $blog_category, 'recent_posts' => $recent_posts]);
        });
    }
}
