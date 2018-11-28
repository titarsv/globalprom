<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Products;
use App\Models\Modules;
use App\Models\Moduleslideshow;
use App\Models\Categories;
use App\Models\Blog;
use App\Models\News;
use App\Http\Requests;
use App\Models\Image;
use App\Models\HTMLContent;


class MainController extends Controller
{
    public function index(Categories $categories, Image $image, Modules $modules, Moduleslideshow $slideshow)
    {
        //$articles = Blog::where('published', 1)->orderBy('updated_at', 'desc')->take(4)->get();
        $blog = new Blog();
        $articles = $blog->get_newest();
        $news = NEWS::where('published', 1)->orderBy('updated_at', 'desc')->take(4)->get();

        setlocale(LC_TIME, 'RU');

//        foreach ($articles as $key => $article) {
//            $articles[$key]->date = iconv("cp1251", "UTF-8", $articles[$key]->updated_at->formatLocalized('%d %b %Y'));
//        }

        foreach ($news as $key => $article) {
            $news[$key]->date = iconv("cp1251", "UTF-8", $news[$key]->updated_at->formatLocalized('%d %b %Y'));
        }

        return view('index')
            ->with('settings', Settings::find(1))
            ->with('actions', Products::orderBy('created_at', 'desc')->where('stock', 1)->whereNotNull('action')->where('action', '!=', '')->take(24)->get())
            ->with('articles', $articles)
            ->with('slideshow', $slideshow->all())
            ->with('news', $news)
            ->with('categories', $categories->select('id', 'name', 'url_alias')->where('parent_id', 20)->get());
    }

    /**
     * @param Categories $categories
     * @param Products $products
     * @param Blog $blog
     * @param HTMLContent $html
     * @param null $alias
     * @param null $filters
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function route(Categories $categories, Products $products, News $news, HTMLContent $html, $alias = null, $filters = null){
        $parts = explode('/', str_replace(array('http://', 'https://'), '', url()->current()));
        $part = end($parts);

        $redirects = array(
            'globalprom.com.ua/gruzopodemnoe-oborudovanie/ruchnoe-pto/tali-ruchnie' => '/categories/tali-ruchnye-shesterennye-i-rychazhnye',
            'globalprom.com.ua/gruzopodemnoe-oborudovanie/ruchnoe-pto/lebedki-ruchni' => '/categories/lebedki-ruchnye-barabannye-shesterennye-i-rychazhnye-%28tyagovyi-mehanizm-mtm%29',
            'globalprom.com.ua/gruzopodemnoe-oborudovanie/ruchnoe-pto/lebedki-ruchnie/lebedka-ruchnaja-shesterennaja/lebedka-ruchnaja-shesterennaja-1' => '/categories/lebedka-ruchnaja-shesterennaja',
            'globalprom.com.ua/gruzopodemnoe-oborudovanie/ruchnoe-pto/stropi/kompl-dlja-strop' => '/categories/komplektuyuschie-dlya-strop',
            'globalprom.com.ua/gruzopodemnoe-oborudovanie/ruchnoe-pto/shtabeleri-rocla' => '/categories/gidravlicheskie-pod%27emniki-%28shtabelery-rokly%29',
            'globalprom.com.ua/promishlennoe-oborudovanie/domkrati/domkrati-reechnie' => '/categories/domkrati-reechnie',
            'globalprom.com.ua/gruzopodemnoe-oborudovanie/tali-i-lebedki-jelektricheskie/telfer-jelektricheskij-ra-220-v' => '/categories/tali-elektricheskie-ra-%28220-v%29',
            'globalprom.com.ua/promishlennoe-oborudovanie/reduktora-motor-reduktora-jelektrodvigateli/reduktori-chervjachnie-2ch' => '/product/reduktory-chervyachnye-2ch',
            'globalprom.com.ua/promishlennoe-oborudovanie/reduktora-motor-reduktora-jelektrodvigateli/reduktori' => '/categories/reduktory',
        );

        if(isset($redirects[str_replace(array('http://', 'https://'), '', url()->current())])){
            return redirect($redirects[str_replace(array('http://', 'https://'), '', url()->current())], 301);
        }elseif($categories->where('url_alias', $part)->count()){
            return redirect()->action(
                'CategoriesController@show', ['alias' => $part], 301
            );
        }elseif(count($parts) > 2 && $products->where('url_alias', $part)->count()){
            return redirect()->action(
                'ProductsController@show', ['alias' => $part], 301
            );
        }elseif(count($parts) == 2 && $news->where('url_alias', $part)->count()){
            return redirect()->action(
                'NewsController@show', ['alias' => $part], 301
            );
        }elseif(count($parts) == 2 && $html->where('url_alias', $part)->count()){
            return redirect()->action(
                'HTMLContentController@show', ['alias' => $part], 301
            );
        }elseif(in_array(substr($part, -4), ['.jpg', '.png', 'jpeg'])){
            $image = new Image();
            return redirect($image->first()->url(), 301);
        }

        return abort(404);
    }
}
