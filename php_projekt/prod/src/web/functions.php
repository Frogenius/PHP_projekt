<?php
require '../../vendor/autoload.php';
$uploaddir = '//var/www/prod/src/web/gallery/';
//Error flag
ini_set("display_errors", "0");
error_reporting(E_ALL);

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
function &get_cart()
{
    if (!isset($_SESSION['cartp'])) {
        $_SESSION['cartp'] = []; 
    }

    return $_SESSION['cartp'];
}

function clear_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cartp'])) {
        $_SESSION['cartp'] = [];

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
   
function imageresizeTM($outfile,$infile,$newwidth,$quality, $oldwidth, $oldheight, $type) {	
	$typestr = 'jpeg'; 
    $kimg=$oldwidth/$newwidth;
	$newheight=(integer)($oldheight / $kimg);  	
	$im=null;				
	switch($type){		
		case 2:
			$im = @imagecreatefromjpeg($infile);
			break;		
		case 3:
			$im = @imagecreatefrompng($infile);
			break;			
	}	
	$im1=imagecreatetruecolor($newwidth,$newheight);	
	imagecopyresampled($im1,$im,0,0,0,0,$newwidth,$newheight,imagesx($im),imagesy($im));
    imagejpeg($im1,$outfile,$quality);
    imagedestroy($im);	
	return;
}

function excess($files) {
		$result = array();
		for ($i = 0; $i < count($files); $i++) {
		  if (  stripos( $files[$i],"tm_" )===0 )$result[] = $files[$i];		  
		} 		
		return $result;
}
