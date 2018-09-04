<?php

	include "../vendor/autoload.php";

	use Atiksoftware\Database\MongoDB;

	$db = new MongoDB();
	# C-connect to server
	$db->connect("mongodb://127.0.0.1:27017", "username","password");
	# connect to database
	$db->setDatebase("public_swain_test");
	# connect to Collection
	$db->setCollection("posts");

	$db->insert([ "_id" => "ucak-0", "name" => "F-".time() ]);

	$db->insert([
		[ "_id" => "ucak-1", "name" => "F-".time() ],
		[ "_id" => "ucak-2", "name" => "F-".time() ],
		[ "_id" => "ucak-3", "name" => "F-".time() ],
	],true);
