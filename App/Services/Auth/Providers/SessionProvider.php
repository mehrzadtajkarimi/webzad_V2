<?php

namespace App\Services\Auth\Providers;

use App\Services\Auth\Contract\AuthProvider;
use App\Services\Session\SessionManager;
use App\Utilities\FlashMessage;

class SessionProvider extends AuthProvider
{
    const AUTH_KEY = 'auth';
    const TIME_EXPIRED = 1;

    public function login(array $param, bool $is_admin = false)
    {
        // dd($param);
		SessionManager::clear();
        $user  = $this->user_model->already_exists($param);
        $token = rand(1000, 9999);
        if (empty($user)) {
            $user_id = $this->user_model->create($param);
            $this->generate_active_code($user_id, $token, $param);
            $this->send_active_code_and_redirect($token, $param, $is_admin);
        }
        $this->token_has_time($user);
        $this->generate_active_code($user['id'], $token, $param);
        $this->send_active_code_and_redirect($token, $param, $is_admin);
    }

    public function is_login()
    {
        return $_SESSION[self::AUTH_KEY] ?? false;
    }
    public function user()
    {
        $id=  $_SESSION[self::AUTH_KEY] ?? false;
        return $this->user_model->read_user($id);
    }

    public function logout()
    {
        if (SessionManager::has(self::AUTH_KEY)) {
            SessionManager::remove(self::AUTH_KEY);
        }
        $this->request->redirect('');
    }

    public function is_token($token, bool $is_admin = false)
    {
        if (isset($_SESSION['phone'])) {
            $user = $this->user_model->first(['phone' => $_SESSION['phone']]);
        }
        if (isset($_SESSION['email'])) {
            $user = $this->user_model->first(['email' => $_SESSION['email']]);
        }
        $is_code =  $this->active_code_model->is_code($token, $user['id']);
        if ($is_code) {
            SessionManager::remove($_SESSION['phone']??'');
            SessionManager::remove($_SESSION['email']??'');
            $_SESSION[self::AUTH_KEY] ?? $_SESSION[self::AUTH_KEY] = $user['id'];
            $this->active_code_model->delete(['user_id' => $user['id']]);
            FlashMessage::add('ورود /ثبت نام با موفقیت انجام شد.');
            if ($is_admin) {
                $this->request->redirect('admin/dashboard');
            }
            $this->request->redirect('profile');
        }
        FlashMessage::add('رمز یکبارمصرفِ وارد شده، نامعتبر بود. دوباره تلاش کنید.', FlashMessage::WARNING);
        if ($is_admin) {
            $this->request->redirect('admin/token');
        }
        $this->request->redirect('token');
    }

    private function send_active_code_and_redirect($token, $param, $is_admin)
    {
        if (isset($param['phone'])) {
            // $send = $this->notification_model->send_token_by_ghasedakSms($token, $param['phone']);
            $send = $this->notification_model->send_token_by_shasfa($token,$param['phone']);
            if ($send) {
                FlashMessage::add('ارسال پیامک با موفقیت انجام شد.');
                $this->request->redirect('token', $is_admin);
            }
            FlashMessage::add('مشکلی در ارسال پیامک رخ داده است. لطفا با پشتیبانی تماس بگیرید.', FlashMessage::WARNING);
            $this->request->redirect('login', $is_admin);
        }
        if (isset($param['email'])) {
            $result = $this->notification_model->send_token_by_email($token, $param['email']);
            if ($result) {
                FlashMessage::add('ارسال ایمیل با موفقیت انجام شد.');
                $this->request->redirect('token', $is_admin);
            }
            FlashMessage::add('مشکلی در ارسال ایمیل رخ داده است. لطفا با پشتیبانی تماس بگیرید.', FlashMessage::WARNING);
            $this->request->redirect('login', $is_admin);
        }
    }

    private function token_has_time($user)
    {
        $expired_at       = strtotime($this->active_code_model->get_expired_at($user['id']));
        $now              = strtotime(date('Y-m-d H:i:s'));
        $token_expired_at = $expired_at - $now;
        if ($token_expired_at > 0 && self::TIME_EXPIRED > $token_expired_at) {
            FlashMessage::add(' کد ارسالی قبلی ' . gmdate("i:s", $token_expired_at) . ' ثانیه دیگر اعتبار دارد ', FlashMessage::WARNING);
            $this->request->redirect('token');
        }
        return;
    }

    private function generate_active_code($user_id, $token, $param)
    {
        $this->insert_active_code($user_id, $token);
        $this->set_session_for_next_request($param);
    }
    private function insert_active_code($user_id, $token)
    {
        $this->active_code_model->create_active_code(
            [
                'user_id'    => $user_id,
                'code'       => $token,
                'expired_at' => date('Y-m-d H:i:s', time() + self::TIME_EXPIRED),
            ]
        );
    }
    private function set_session_for_next_request($param)
    {
        if (isset($param['phone'])) {
            $_SESSION['phone'] = $param['phone'];
        }
        if (isset($param['email'])) {
            $_SESSION['email'] = $param['email'];
        }
    }
}
