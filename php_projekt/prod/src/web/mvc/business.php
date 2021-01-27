<?php

use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Regex;

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}
function get_gallery()
{
    $db = get_db();
    return $db->gallery->find()->toArray();
}
function get_myphotos()
{
	$auphoto=$_SESSION['youname'];	
    $db = get_db();
	$queryAll =	['auphoto' => $auphoto];		
    return $db->gallery->find($queryAll)->toArray();
}
function get_photos()
{
	$auphoto=$_SESSION['youname'];	
    $db = get_db();
	$queryAll = ['$or'=>[
		['auphoto' => $auphoto],
		['privat'=>'2'] ]
	];
    return $db->gallery->find($queryAll)->toArray();
}

function get_findphoto($spfoto)
{	
	$auphoto=$_SESSION['youname'];	
    $db = get_db();
	$query =	['nmphoto' =>  new Regex($spfoto, 'i')];		
    return $db->gallery->find($query)->toArray();
}
function get_photo($id)
{	
    $db = get_db();	
	$picture = $db->gallery->findOne(['_id' => new ObjectID($id)]);	
    return $picture;
	
}
function get_members()
{
	
    $db = get_db();		
    return $db->members->find()->toArray();
}
function is_autor($query){
	$db = get_db();
	$user = $db->members->findOne($query);
	 
	return $user;		
				
}
function add_autor($anketa){
	$db = get_db();
	$db->members->insertOne($anketa);
	return true;
}
function del_member($id){
	$db = get_db();
	 $db->members->deleteOne(['_id' => new ObjectID($id)]);
	return true;
	
}
