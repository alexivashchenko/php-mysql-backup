<?php

// Created: 2020/03/21 20:56:23
// Last modified: 2020/03/21 22:10:14

// Developer: Alexander Ivashchenko
// Site: http://ivashchenko.in.ua/
// Skype: alex_iblisov
// Email: lex.ivashchenko@gmail.com
// https://www.facebook.com/lex.ivashchenko
// https://ua.linkedin.com/pub/alexander-ivashchenko/61/3a5/440

namespace Ali;

use DateTime;

class MysqlBackup
{

	private
		$date_format = 'Y.m.d.H.i.s',
		$file_extension = '.sql.gzip',
		$db = [
			'host' => '127.0.0.1',
			'name' => '',
			'user' => 'root',
			'pass' => '',
		];

	public
		$project_name = 'default',
		$storage_path = __DIR__ . 'storage' . DIRECTORY_SEPARATOR,
		$total_archives = 5,
		$time;

	function __construct(array $data = [])
	{
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				if ($key === 'db' and is_array($key)) {
					foreach ($key as $k => $v) {
						if (isset($this->{$key}[$k])) {
							$this->{$key}[$k] = $v;
						}
					}
				}
				if (isset($this->{$key})) {
					$this->{$key} = $value;
				}
			}
		}

		$this->storage_path = rtrim($this->storage_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

		if (!file_exists($this->storage_path)) {
			if (!mkdir($this->storage_path, 0777, true)) {
				throw new \Exception('Failed to create storage path: ' . $this->storage_path);
			}
		}

		$this->time = strtotime('now');
	}



	public function backupFile()
	{
		return $this->storage_path . $this->project_name . '-' . $this->db['name'] . '-[' . date($this->date_format, $this->time) . ']'.$this->file_extension;
	}




	public function getArchiveDate($file)
	{

		$date = false;

		if (preg_match('/\[(.*?)\]/', $file, $match) == 1) {
			$date = $match[1];
		}

		if ($date !== false) {
			$date_obj = DateTime::createFromFormat($this->date_format, $date);
			$date = $date_obj->getTimestamp();
		}

		return $date;
	}



	public function removeOldArchives($files){
		$removed_files = [];
		foreach ($files as $file_to_remove) {
			if (unlink($this->storage_path . $file_to_remove)) {
				$removed_files[] = $file_to_remove;
			}
		}

		return $removed_files;
	}




	public function updateStorage()
	{

		$all_files = array_diff(scandir($this->storage_path), ['.', '..']);

		$files = [];

		foreach ($all_files as $file) {
			$files[$this->getArchiveDate($file)] = $file;
		}

		ksort($files);

		$files_to_remove = array_slice($files, 0, (count($files) - $this->total_archives), true);

		return [
			'actual' => array_values(array_diff($all_files, $files_to_remove)),
			'removed' => $this->removeOldArchives($files_to_remove)
		];
	}





	public function init()
	{

		$dump = new \Ifsnop\Mysqldump\Mysqldump(
			'mysql:host=' . $this->db['host'] . ';dbname=' . $this->db['name'],
			$this->db['user'],
			$this->db['pass'],
			[
				'compress' => 'Gzip',
			]
		);

		$dump->start($this->backupFile());


		if (!file_exists($this->backupFile())) {
			throw new \Exception('Failed to create backup file: ' . $this->backupFile());
		}

		return $this->updateStorage();
	}
}
