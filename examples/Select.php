<?php

	include "../vendor/autoload.php";

	use Atiksoftware\Database\MongoDB;

	$db = new MongoDB();
	# connect to server ->  ("mongodb://127.0.0.1:27017","swainDb","Ss_*++1236547852")
	$db->connect(CONF_DB_MONGODB_HOSTNAME, CONF_DB_MONGODB_USERNAME,CONF_DB_MONGODB_PASSWORD);
	# connect to database
	$db->setDatebase("public_swain_test");
	# connect to Collection
	$db->setCollection("testler");

	$rows = $db
		->orderBy(["_id" => 1])
		->projectBy(["title.TR" => 1])
		->limit(1)
		->skip(1)
		->select();
		// ->count();
	print_r($rows);
