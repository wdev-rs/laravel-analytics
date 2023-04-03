<?php

namespace WdevRs\LaravelAnalytics\Http\Middleware;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Closure;
use Throwable;
use WdevRs\LaravelAnalytics\Models\PageView;

class Analytics
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$request->isMethod('GET')) {
            return $response;
        }

        if ($request->isJson()) {
            return $response;
        }

        try {
            /** @var PageView $pageView */
            $pageView = PageView::make([
                'session_id' => session()->getId(),
                'path' => $request->path(),
                'user_agent' => $request->userAgent(),
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