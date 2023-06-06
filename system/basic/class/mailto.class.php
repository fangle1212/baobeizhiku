<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class mailto
{
    public static $host;
    public static $port;
    public static $user;
    public static $password;
    public static $socket;

    public static function init()
    {
		global $G;
		$bosscms;
        self::$password = $G['config']['mail_password'];
        self::$user = $G['config']['mail_user'];
        self::$port = is_numeric($G['config']['mail_port'])?$G['config']['mail_port']:443;
        self::$host = (self::$port==25?'tcp://':'ssl://').$G['config']['mail_host'];
        self::$socket = fsockopen(self::$host, self::$port);
		if(self::$socket){
			preg_match('/\d+/is', fgets(self::$socket), $match);
			$G['email'] = (self::$socket && in_array(220, $match));
		}
    }
	
	public static function detail($recipient, $title, $content)
	{
		return
			'MIME-Version: 1.0'."\r\n".
			'Content-Type:text/html;charset=utf-8'."\r\n".
			'From: '.self::$user."\r\n".
			'To: '.$recipient."\r\n".
			'Subject: '.$title."\r\n".
			"\r\n".
			preg_replace("/(^|(\r\n))(\.)/","\1.\3",$content)."\r\n".
			'.'."\r\n";
	}
	
	public static function details($recipient, $title, $content, $files)
	{
		$files = is_array($files)?$files:array($files);
		$text = 
			'From: '.self::$user."\r\n".
			'To: '.$recipient."\r\n".
			'Subject: =?UTF-8?B?'.base64_encode($title).'?='."\r\n".
			'Mime-Version: 1.0'."\r\n".
			'Content-Type: multipart/mixed;'."\r\n".
			'    boundary="--==BOUNDARY++"'."\r\n".
			'Content-Transfer-Encoding: 8Bit'."\r\n".
			'----==BOUNDARY++'."\r\n".
			'Content-Type: multipart/alternative;'."\r\n".
			'    boundary="++==BOUNDARY--"'."\r\n".
			"\r\n".
			'--++==BOUNDARY--'."\r\n".
			'Content-Type: text/html;'."\r\n".
			'    charset="utf-8"'."\r\n".
			'Content-Transfer-Encoding: base64'."\r\n".
			"\r\n".
			base64_encode($content)."\r\n".
			"\r\n".
			'--++==BOUNDARY----'."\r\n";
		foreach($files as $path){
			$info = pathinfo($path);
			$text .= 
				"\r\n".
				'----==BOUNDARY++'."\r\n".
				'Content-Type: application/octet-stream;'."\r\n".
				'    charset="utf-8";'."\r\n".
				'    name="'.$info['basename'].'"'."\r\n".
				'Content-Disposition: attachment; filename="'.$info['basename'].'"'."\r\n".
				'Content-Transfer-Encoding: base64'."\r\n".
				"\r\n".
				base64_encode(file_get_contents($path))."\r\n";
		}
		$text .= 
			"\r\n".
			'----==BOUNDARY++--'."\r\n".
			'.'."\r\n";
		return $text;
	}
	
    public static function run($cmd, $code=null){
		if(self::$socket){
			fwrite(self::$socket, $cmd);
			$res = fgets(self::$socket);
			if(isset($code)){
				preg_match('/\d+/is', $res, $match);
				return in_array($code, $match);
			}
		}
    }

    public static function send($recipient, $title, $content, $files=null)
	{
		self::run("HELO ".self::$host."\r\n");
		self::run("AUTH LOGIN\r\n");
		self::run(base64_encode(self::$user)."\r\n");
		self::run(base64_encode(self::$password)."\r\n");
		self::run("MAIL FROM:<".self::$user.">\r\n");
		self::run("RCPT TO:<".$recipient.">\r\n");
		self::run("DATA\r\n"); /* BOSS_CMS */
		return self::run($files?self::details($recipient,$title,$content,$files):self::detail($recipient,$title,$content), 250);
    }
	
	public static function close()
	{
		if(self::$socket){
        	fclose(self::$socket);
		}
	}
}
?>