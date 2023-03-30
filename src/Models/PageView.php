<?php

namespace WdevRs\LaravelAnalytics\Models;

use Database\Factories\PageViewFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function newFactory(): Factory
    {
        return PageViewFactory::new();
    }

    public function __construct(array $attributes = [])
    {
        $this->table = config('laravel-analytics.db_prefix') . 'page_views';

        parent::__construct($attributes);
    }


    public function pageModel()
    {
        return $this->morphTo();
    }
}
