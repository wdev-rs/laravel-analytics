<?php

namespace WdevRs\LaravelAnalytics\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use WdevRs\LaravelAnalytics\Models\PageView;

class PageViewRepository
{

    public function getByDate(Carbon $date): Collection
    {
        return PageView::query()
                    ->where('created_at', '>=', $date)
                    ->get();
    }

    public function getByDateGroupedByPath(Carbon $date): Collection
    {
        return PageView::query()
            ->selectRaw('COUNT(id) as count, path' )
            ->where('created_at', '>=', $date)
            ->groupBy('path')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'path');
    }

    public function getByDateGroupedByDays(Carbon $date): Collection
    {
        return PageView::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as count') )
            ->where('created_at', '>=', $date)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');
    }


}