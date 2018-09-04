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


	$db->when(["_id" => "ucak-1"])->update(["name" => "F-".time()],true);
	$db->when(["_id" => "ucak-2"])->update(["name" => "F-".time()],true);
	$db->when(["_id" => "ucak-3"])->update(["name" => "F-".time()],true);
	$db->when(["_id" => "ucak-4"])->update(["name" => "F-".time()],true);
