<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Blog extends Model
{
    protected $table = 'wp_posts';

    public $fillable = [
        'ID',
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count'
    ];

    public function get_newest(){
        $articles = $this->where('post_status', 'publish')
            ->where('post_type', 'post')
            ->take(4)
            ->orderBy('post_date', 'desc')
            ->get()
            ->toArray();

        foreach($articles as $i => $article){
            $image_id = DB::table('wp_postmeta')->where('post_id', $article['ID'])->where('meta_key', '_thumbnail_id')->pluck('meta_value')->first();
            if(!empty($image_id)){
                $articles[$i]['image'] = '/blog/wp-content/uploads/'.DB::table('wp_postmeta')->where('post_id', $image_id)->where('meta_key', '_wp_attached_file')->pluck('meta_value')->first();
            }
        }

        return $articles;
    }

    //use SoftDeletes;

//    protected $dates = ['deleted_at'];
//
//    protected $table = 'blog';
//
//    public $fillable = [
//        'user_id',
//        'url_alias',
//        'title',
//        'subtitle',
//        'text',
//        'published',
//        'image_id',
//        'meta_title',
//        'meta_keywords',
//        'meta_description'
//    ];
//
//    public function user()
//    {
//        return $this->belongsTo('App\Models\User');
//    }
//
//    public function image()
//    {
//        return $this->belongsTo('App\Models\Image');
//    }
//
//    /**
//     * Получение случайных постов
//     * @param $count
//     * @param $exclusion
//     * @return mixed
//     */
//    public function get_recommended($count, $exclusion = 0){
//        return $this->where('published', true)
//            ->take($count)
//            ->whereNotIn('id', array($exclusion))
//            ->inRandomOrder()
//            ->get();
//    }
}