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

	$db->when(["age" => ['$gt' => 20]])->remove();
