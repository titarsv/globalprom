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

        $img = new Image();

        foreach($articles as $i => $article){
            $image_id = DB::table('wp_postmeta')->where('post_id', $article['ID'])->where('meta_key', '_thumbnail_id')->pluck('meta_value')->first();
            if(!empty($image_id)){
                $image = public_path().'/blog/wp-content/uploads/'.DB::table('wp_postmeta')->where('post_id', $image_id)->where('meta_key', '_wp_attached_file')->pluck('meta_value')->first();
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION ));
                $limg = str_replace('.'.$extension, '_larevel.'.$extension, $image);
                $webp = str_replace('.'.$extension, '_larevel.webp', $image);
                if(!is_file($limg)){
                    $file = $img->imagecreatefromfile($image);
                    $k1=160/imagesx($file);
                    $k2=160/imagesy($file);
                    $k=$k1<$k2?$k2:$k1;

                    $w=intval(imagesx($file)*$k);
                    $h=intval(imagesy($file)*$k);

                    $im1=imagecreatetruecolor($w,$h);
                    imagecopyresampled($im1,$file,0,0,0,0,$w,$h,imagesx($file),imagesy($file));

                    if($extension == 'png'){
                        imagepng($im1, $limg, 3);
                    }elseif(in_array($extension, ['jpeg', 'jpg'])){
                        imagejpeg($im1, $limg, 80);
                    }elseif(in_array($extension, ['gif'])){
                        imagegif($im1, $limg);
                    }
                    imagedestroy($file);
                    imagedestroy($im1);
                }
                if(!is_file($webp)){
                    $file = $img->imagecreatefromfile($limg);
                    imagewebp($file, $webp);
                    imagedestroy($file);
                }
                $mime = $extension;
                if($mime == 'jpg'){
                    $mime = 'jpeg';
                }

                $articles[$i]['image'] = view('public.layouts.webp_blog')
                    ->with('original', str_replace(public_path(), '', $limg))
                    ->with('original_mime', $mime)
                    ->with('webp', str_replace(public_path(), '', $webp))
                    ->with('attributes', ['alt' =>  $article['post_title']])
                    ->with('lazy', 'static')
                    ->render();
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