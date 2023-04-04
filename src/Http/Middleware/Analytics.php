<?php

namespace WdevRs\LaravelAnalytics\Http\Middleware;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Str;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Throwable;
use WdevRs\LaravelAnalytics\Models\PageView;

class Analytics
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            if (!$request->isMethod('GET')) {
                return $response;
            }

            if ($request->isJson()) {
                return $response;
            }

            $userAgent = $request->userAgent();

            if (is_null($userAgent)) {
                return $response;
            }

            /** @var CrawlerDetect $crawlerDetect */
            $crawlerDetect = app(CrawlerDetect::class);

            if ($crawlerDetect->isCrawler($userAgent)) {
                return $response;
            }

            /** @var PageView $pageView */
            $pageView = PageView::make([
                'session_id' => session()->getId(),
                'path' => $request->path(),
                'user_agent' => Str::substr($userAgent, 0, 255),
                'ip' => $request->ip(),
                'referer' => $request->headers->get('referer'),
            ]);

            $parameters = $request->route()?->parameters();
            $model = null;

            if (!is_null($parameters)) {
                $model = reset($parameters);
            }

            if (is_a($model, Model::class)) {
                $pageView->pageModel()->associate($model);
            }

            $pageView->save();

            return $response;
        } catch (Throwable $e) {
            report($e);
            return $response;
        }
    }
}