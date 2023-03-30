<?php

namespace WdevRs\LaravelAnalytics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $guarded = ['id'];

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
