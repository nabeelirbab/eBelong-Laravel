<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LimitPageViews
{
    public function handle($request, Closure $next)
    {
        // Check if the user is already authenticated and the request expects a full page view
        if (!auth()->check() && !$request->ajax() && $request->isMethod('get')) {
            // Get the current number of page views
            $views = session('page_views', 0);
            // Increment the page views count
            session(['page_views' => ++$views]);

            // If the view count exceeds the limit and the request is not for an asset or an API endpoint
            if ($views > 9 && !$this->isApiOrAssetRequest($request)) {
                // Reset the page views count
                session(['page_views' => 0]);

                // Set the session variable to trigger the modal
                session(['show_registration_modal' => true]);
            }
        }

        // Continue with the request
        return $next($request);
    }

    /**
     * Determine if the request is for an API or an asset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isApiOrAssetRequest($request)
    {
        return $request->is('api/*') || $request->is('*.css') || $request->is('*.js') || $request->is('*.jpg') || $request->is('*.png') || $request->is('*.gif');
    }
}
