<?php

namespace App\Core\Middleware;

use App\Core\Middleware\Contract\MiddlewareInterface;
use App\Services\Auth\Auth;
use App\Services\Log\LogManager;

class Gate implements MiddlewareInterface
{
    public function handle()
    {
        global $request;
        // $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // echo '<pre>'; var_dump($_SERVER['REQUEST_URI']); echo '</pre>';
        // echo '<pre>'; var_dump($actual_link); echo '</pre>';

        // die;
        // $activity_log = new LogManager();
        // $activity_log->set_see_log([
        //     'user_id'      => Auth::is_login(),
        //     'ip'           => $request->ip(),
        //     'http_referer' => urldecode($request->http_referer()),
        //     'request_uri'  => urldecode($request->uri()),
        // ]);

        return;
    }
}
