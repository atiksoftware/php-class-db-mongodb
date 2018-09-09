<?php

	include "../vendor/autoload.php";

	use Atiksoftware\Database\MongoDB;

	$db = new MongoDB();
	# connect to server ->  ("mongodb://127.0.0.1:27017","swainDb","Ss_*++1236547852")
	$db->connect(CONF_DB_MONGODB_HOSTNAME, CONF_DB_MONGODB_USERNAME,CONF_DB_MONGODB_PASSWORD);
	# connect to database
	$db->setDatabase("public_swain_test");
	# connect to Collection
	$db->setCollection("testler");

	for($i = 0 ;  $i < 200 ; $i++){
		$db->insert([
			"_id"    => "row-{$i}",
			"number" => $i,
			"date"   => [ "add" => time()]
		]);
	}


	$db->insert([
		[ "_id" => "ucak-1", "name" => "F-".time() ],
		[ "_id" => "ucak-2", "name" => "F-".time() ],
		[ "_id" => "ucak-3", "name" => "F-".time() ],
	],true);
