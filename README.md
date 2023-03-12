# Rebuilding docs/db/ folder

1. Install PHP Composer

Paste [these commands](https://getcomposer.org/download/) to install PHP

Then run `php composer.phar`

2. Unzip database

Link the contents of a `db.zip` backup into `/content`.

The folder structure should look like:

* `/content/database/Files/2021/`
* `/content/database/Files/Tags.txt`

3. Build

Run `php scripts/build_db.php`