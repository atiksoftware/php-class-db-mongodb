# PHP MongoDB database class

This is php class for connect to mogodb with php. Its working on PHP.7 for now. i will add functions for php.5x

----------
## Installation

### Using Composer

```sh
composer require atiksoftware/php-class-db-mongodb
```

```php
require __DIR__.'/../vendor/autoload.php';

use Atiksoftware\Database\MongoDB;
$db = new MongoDB();
```
#### _connect to server_
```php
$db->connect("mongodb://127.0.0.1:27017", "username","password");
```
#### _connect to Database_
```php
$db->setDatebase("public_swain_test");
```
#### _connect to Collection_
```php
$db->setCollection("posts");
```

#### _Select_
```php
$db
		->orderBy(["_id" => 1])
		->projectBy(["title.TR" => 1])
		->limit(1)
		->skip(1)
		->select();
```





