# php-mysql-backup


## Description

Simple PHP class to create regular MySQL database backups.

### What it does:

1. Create MySQL database backup.
2. Remove old MySQL database backups.

The output is the set of `sql.gzip` files.




## Installation

### Composer

From the Command line:

```
composer require alexivashchenko/php-mysql-backup:dev-master
```

In `composer.json`:
```
{
	"require": {
		"alexivashchenko/php-mysql-backup": "dev-master"
	}
}
```


## Usage

1. Create `config.php` file, set up right `VENDOR_PATH` and `$Config`.
2. Create CRON job to run `run-backup.php` file.





