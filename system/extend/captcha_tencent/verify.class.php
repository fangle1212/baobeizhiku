<?php
define('TenCaptchaVALoad','vendor/autoload.php');
require_once TenCaptchaVALoad;

use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Captcha\V20190722\CaptchaClient;
use TencentCloud\Captcha\V20190722\Models\DescribeCaptchaResultRequest;

class verify
{
	public static function _describe($randstr, $ticket)
	{
		global $G;
		try {
			$cred = new Credential($G['config']['captcha_id'],$G['config']['captcha_key']);
			$httpProfile = new HttpProfile();
			$httpProfile->setEndpoint("captcha.tencentcloudapi.com");
			$clientProfile = new ClientProfile();
			$clientProfile->setHttpProfile($httpProfile);
			$client = new CaptchaClient($cred, "", $clientProfile);
			$req = new DescribeCaptchaResultRequest();
			$params = array(
				"CaptchaType" => 9,
				"CaptchaAppId" => intval($G['config']['captcha_appid']),
				"AppSecretKey" => $G['config']['captcha_appkey'],
				"UserIp" => getIP(),
				"Randstr" => $randstr,
				"Ticket" => $ticket
			);
			$req->fromJsonString(json_encode($params));
			return $client->DescribeCaptchaResult($req);
		}
		catch(TencentCloudSDKException $e){ }
	}
}
?>