# PHP MongoDB database class

This is php class for connect to mogodb with php. Its working on PHP.5 mongo and PHP.7 mongodb  

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

#### _Insert_
```php
$db->insert([ "_id" => "ucak-0", "name" => "F-".time() ]);
$db->insert([
    [ "_id" => "ucak-1", "name" => "F-".time() ],
    [ "_id" => "ucak-2", "name" => "F-".time() ],
    [ "_id" => "ucak-3", "name" => "F-".time() ],
],true);
```

#### _Update_
```php
$db->when(["_id" => "ucak-1"])->update(["name" => "F-".time()],true);
$db->when(["_id" => "ucak-2"])->update(["name" => "F-".time()],true);
$db->when(["_id" => "ucak-3"])->update(["name" => "F-".time()],true);
$db->when(["_id" => "ucak-4"])->update(["name" => "F-".time()],true);
```

#### _Remove_
```php
$db->when(["age" => ['$gt' => 20]])->remove();
```



