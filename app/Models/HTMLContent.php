<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HTMLContent extends Model
{
    protected $table = 'html_content';
    protected $fillable = [
        'name',
        'url_alias',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'robots',
        'content',
        'status',
        'sort_order'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
