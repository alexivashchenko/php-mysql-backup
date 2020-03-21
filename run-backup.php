<?php

// Created: 2020/03/21 20:41:32
// Last modified: 2020/03/21 22:15:46

// Developer: Alexander Ivashchenko
// Site: http://ivashchenko.in.ua/
// Skype: alex_iblisov
// Email: lex.ivashchenko@gmail.com
// https://www.facebook.com/lex.ivashchenko
// https://ua.linkedin.com/pub/alexander-ivashchenko/61/3a5/440


if (!defined('ACCESS')) {
	define('ACCESS', true);
}

require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

require VENDOR_PATH . 'autoload.php';

global $Config;


if( !function_exists('pr') ){
	function pr(...$data){
		if( !empty($data) ){
			foreach( $data as $key => $value ){
				echo (php_sapi_name() === 'cli') ? '' : '<pre data-key="'.$key.'" style="padding:1rem;margin:0;background-color:#333;color:#fff;max-height:90vh;overflow:auto;border-bottom:1px solid #666;">';
				print_r($value);
				echo (php_sapi_name() === 'cli') ? '' : '</pre>';
			}
		}
	}
}



$MysqlBackup = new Ali\MysqlBackup($Config);

pr($MysqlBackup->init());

