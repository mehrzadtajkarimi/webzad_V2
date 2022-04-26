<?php

namespace App\Services\Payment\Online\Gateway;

use App\Services\Payment\Contract\OnlineGateway;

class ZarinPal implements OnlineGateway
{
        const MERCHANT_ID = '6e73672e-d085-4141-b99a-181c945dca41';

        // from app to gateway
        public function payRequest($params)
        {
                $Amount      = $params['amount'];                                            //Amount will be based on Toman - Required
                $Description = $params['description'];                                       // Required
                $Email       = $params['email'] ?? '';                                       // Optional
                $Mobile      = $params['mobile'] ?? '';                                      // Optional
                $CallbackURL = $params['callback_url'] ?? base_url('payment-verification');  // Required


                $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

                $result = $client->PaymentRequest(
                        [
                                'MerchantID'  => self::MERCHANT_ID,
                                'Amount'      => $Amount,
                                'Description' => $Description,
                                'Email'       => $Email,
                                'Mobile'      => $Mobile,
                                'CallbackURL' => $CallbackURL,
                        ]
                );


                //Redirect to URL You can do it also by creating a form
                if ($result->Status == 100) {
                        Header('Location: https://www.zarinpal.com/pg/StartPay/' . $result->Authority);
                        //برای استفاده از زرین گیت باید ادرس به صورت زیر تغییر کند:
                        //Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'/ZarinGate');
                } else {
                        echo 'ERR: ' . $result->Status;
                }
        }


        // form gateway to app
        // TODO: refactor and fix it !
        public function verifyRequest($params)
        {
                $Amount    = $params['amount'];   //Amount will be based on Toman - Required
                $Authority = $_GET['Authority'];

                if ($_GET['Status'] == 'OK') {
                        $client = new \SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
                        $result = $client->PaymentVerification(
                                [
                                        'MerchantID' => self::MERCHANT_ID,
                                        'Authority'  => $Authority,
                                        'Amount'     => $Amount,
                                ]
                        );
                        var_dump($result);

                        if ($result->Status == 100) {
                                echo 'Transaction success. RefID: <br>' . $result->RefID;
                                return true;
                        } else {
                                echo 'Transaction failed. Status: <br>' . self::get_message($result->Status);
                        }
                } else {
                        echo 'Transaction canceled by user';
                }
                return false;
        }


        public static function get_message(int $code)
        {
                $message = '';
                switch ($code) {
                        case '-1':
                                $message = 'اطلاعات ارسال شده ناقص است!';
                                break;
                        case '-2':
                                $message = 'آی پی و یا مرچنت کد پذیرنده صحیح نیست!';
                                break;
                        case '-3':
                                $message = 'با توجه به محدودیت های شاپرک امکان پرداخت با رقم در خواست شده میسر نمی باشد!';
                                break;
                        case '-4':
                                $message = 'سطح تایید پذیرنده پایین تر از سطح نقره ای است!';
                                break;
                        case '-11':
                                $message = 'در خواست مورد نظر یافت نشد!';
                                break;
                        case '-12':
                                $message = 'امکان ویرایش در خواست میسر نمی باشد!';
                                break;
                        case '-21':
                                $message = ' هیچ نوع عملیات مالی برای این تراکنش یافت نشد!';
                                break;
                        case '-22':
                                $message = 'تراکنش نا موفق میباشد!';
                                break;
                        case '-33':
                                $message = 'رقم تراکنش با رقم پرداخت شده مطابقت ندارد!';
                                break;
                        case '-34':
                                $message = 'سقف تقسیم تراکنش از لحاظ تعداد یا رقم عبور نموده است!';
                                break;
                        case '-40':
                                $message = 'اجازه دسترسی به متد مربوطه وجود ندارد!';
                                break;
                        case '-41':
                                $message = 'اطلاعات ارسال شده مربوط به Additional Data غیر معتبر می باشد!';
                                break;
                        case '-42':
                                $message = 'مدت زمان معتبر طول عمر شناسه پرداخت باید بین ۳۰ دقیقه تا ۴۵ روز میباشد!';
                                break;
                        case '-54':
                                $message = 'در خواست موردنظر آرشیو شده است!';
                                break;
                        case '100':
                                $message = 'عملیات  پرداخت با موفقیت انجام گردید!';
                                break;
                        case '101':
                                $message = 'عملیات پرداخت موفق بوده و قبلا PaymentVerification تراکنش انجام شده است!';
                                break;
                        default:
                                $message = 'یک خطا در عملیات پرداخت رخ داده است!';
                }
                return $message;
        }
}
