<?php

namespace App\Services\Auth;

use App\Services\Sms\Sms;
use Ghasedak\GhasedakApi;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use SoapClient;

class Notification
{

    function send_token_by_ghasedakSms($token, $phone)
    {
        try {
            $send_sms = new GhasedakApi($_ENV['GHASEDAK_TOKEN']);
            return $send_sms->SendSimple($phone, "کدتایید usedkala\n$token", "10008566");
        } catch (\Ghasedak\Exceptions\ApiException $e) {
            echo $e->errorMessage();
        } catch (\Ghasedak\Exceptions\HttpException $e) {
            echo $e->errorMessage();
        }
    }
    function send_token_by_shasfa($token,$phone)
    {
		// die('token: '.$token);
		/*
        //call soap client
        $soap = new SoapClient("http://shasfa.com/webservice/send.php?wsdl");


        //SendSMS
        $soap->Username = "mehrzad"; //Your Username
        $soap->Password = "y7gPNmTq7BuUeJg"; // Your Password
        $soap->fromNum = "+9810004132890007"; // Your Number (for example "+98100033333731")
        $soap->toNum = array("$phone");
        $soap->Content = "کدتایید usedkala\n$token";
        $soap->Type = '0';

        return $soap->SendSMS($soap->fromNum, $soap->toNum, $soap->Content, $soap->Type, $soap->Username, $soap->Password);
		*/
		$postData = [
			'gateway' => 100069183656,
			'to' => $phone,
			'text' => "کدتایید usedkala\n$token"
		];
		$ch = curl_init('https://api.sabanovin.com/v1/sa793522704:ZUXfTpVBhArIpYThQ3ff00F9kTKcXcIYP0ht/sms/send.json');
		// curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json','x-sms-ir-secure-token: '.$result['TokenKey']]);
		// curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		$result = curl_exec($ch);
		curl_close($ch);
		return($result);
    }
    function send_token_by_email($token, $email)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = "smtp.gmail.com";
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USER'];
            $mail->Password   = $_ENV['MAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet = 'UTF-8';

            $mail->SetFrom($_ENV['MAIL_USER']);
            $mail->AddAddress($email);
            $mail->isHTML(true);

            $mail->Subject = "usedkala کد تایید";
            $mail->Body    = "<html><body>این کد تاییدیه ورود است! <br><font color='#CC0000'><h3>$token</h3></font> </body></html>";
            $mail->AltBody = 'برنامه شما از این ایمیل پشتیبانی نمی کند، برای مشاهده آن لطفا از برنامه دیگری استفاده نمائید';

            $mail->send();
            // $mail->smtpClose();
            return true;
        } catch (\Exception $e) {
            echo "خطا: ایمیل ارسال نشد " . $mail->ErrorInfo;
        }
    }
}
