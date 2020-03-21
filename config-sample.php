<?php if (!defined('ACCESS')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

// Created: 2020/03/21 20:41:42
// Last modified: 2020/03/21 20:41:42

// Developer: Alexander Ivashchenko
// Site: http://ivashchenko.in.ua/
// Skype: alex_iblisov
// Email: lex.ivashchenko@gmail.com
// https://www.facebook.com/lex.ivashchenko
// https://ua.linkedin.com/pub/alexander-ivashchenko/61/3a5/440



define('ABS', __DIR__ . DIRECTORY_SEPARATOR);

define('VENDOR_PATH', ABS . 'inc' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);

$Config = [
	'project_name' => '__PROJECT_NAME__',
	'storage_path' => ABS . 'storage' . DIRECTORY_SEPARATOR,
	'db' => [
		'host' => '127.0.0.1',
		'name' => '__DB_NAME__',
		'user' => 'root',
		'pass' => '',
	],
	'total_archives' => 5,
];
