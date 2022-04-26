<?php

namespace App\Core\Middleware;

use App\Core\Middleware\Contract\MiddlewareInterface;
use App\Models\User;
use App\Services\Session\SessionManager;
use App\Utilities\FlashMessage;

class Auth extends User implements MiddlewareInterface
{
    public function handle()
    {
        global $request;

        // if ($request->segment(1) == 'admin') {
        //     // return;
        //     if (isset($_POST['token']) || SessionManager::get('auth') && $this->is_admin(SessionManager::get('auth'))) {
        //         return;
        //     }
        //     // FlashMessage::add("ابتدا وارد شوید :(", FlashMessage::WARNING);
        //     return $request->redirect('admin/login');
        // }
    }
}