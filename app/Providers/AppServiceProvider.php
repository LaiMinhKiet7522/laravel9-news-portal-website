<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\OnlinePoll;
use App\Models\SidebarAdvertisement;
use App\Models\TopAdvertisement;
use App\Models\LiveChannel;
use App\Models\SocialItem;
use Illuminate\Pagination\Paginator as PaginationPaginator;
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
        PaginationPaginator::useBootstrap();
        
        $top_ad_data = TopAdvertisement::where('id', 1)->first();
        $page_data = Page::where('id', 1)->first();
        $recent_news_data = Post::with('rSubCategory')->orderBy('id','desc')->get();
        $popular_news_data = Post::with('rSubCategory')->orderBy('visitors','desc')->get();
        $sidebar_top_ad = SidebarAdvertisement::where('sidebar_ad_location','Top')->get();
        $sidebar_bottom_ad = SidebarAdvertisement::where('sidebar_ad_location','Bottom')->get();
        $live_channel_data = LiveChannel::get();
        $online_poll_data = OnlinePoll::orderBy('id','desc')->first();
        $social_item_data = SocialItem::orderBy('id','desc')->get();  
        $categories = Category::with('rSubCategory')->where('show_on_menu','Show')->orderBy('category_order','asc')->get();
        view()->share('global_top_ad_data', $top_ad_data);
        view()->share('global_sidebar_top_ad', $sidebar_top_ad);
        view()->share('global_sidebar_bottom_ad', $sidebar_bottom_ad);
        view()->share('global_categories', $categories);
        view()->share('global_page_data', $page_data);
        view()->share('global_live_channel_data', $live_channel_data);
        view()->share('global_recent_news_data', $recent_news_data);
        view()->share('global_popular_news_data', $popular_news_data);
        view()->share('global_online_poll_data', $online_poll_data);
        view()->share('global_social_item_data', $social_item_data);
    }
}
