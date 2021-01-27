<?php 
session_start(); 

    if (!isset($_SESSION['cartp'])) {
        $_SESSION['cartp'] = []; 
		setcookie("cartp", serialize($_SESSION['cartp']), time() + 60 * 60 * 24 * 5, "/"); 
    }else{
		setcookie("cartp", serialize($_SESSION['cartp']), time() + 60 * 60 * 24 * 5, "/"); 
	}
?>
<!DOCTYPE html>
<html lang="pl">
 <head>
    <title>Rock clambing</title>                               
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css"/>    
    <script type="text/javascript" src="./js/jquery.min.js"></script>   
    <script type="text/javascript" src="./js/myscript.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
    <link href="./js/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link rel="import" href="menu.htm">
 </head>
 <body onload="onloadname()">
    <div class="pagec">
		<?php
			include_once('navi.htm' ); 
		?>		
		<div class="content1">
            <div class="content_in">



<?php

require_once 'functions.php';
use MongoDB\BSON\ObjectID;

$db = get_db();
$picture=null;
$id=null;
if (!empty($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

	$picture = $db->gallery->findOne(['_id' => new ObjectID($id)]);	

}
	
if ($_SERVER['REQUEST_METHOD'] === 'GET' ){
	if (isset($_GET['tocart'])) {
		$tocart=$_GET['tocart'];		
		$cartp = &get_cart();
		$cartp[$id] = ['nmphoto' => $picture['nmphoto'], 'auphoto' => $picture['auphoto'], 'desc' => $picture['desc'], 'tm' => $picture['tm'], 'id'=>$id ];
		echo '<script type="text/javascript">'; 
		echo 'window.location.href="view.php?id='.$id.'";'; 
		echo '</script>'; 
	}else if(isset($_GET['del'])) {
		$del=$_GET['del'];		
		$cartp = &get_cart();
		unset($cartp[$del]);
		echo '<script type="text/javascript">'; 
		echo 'window.location.href="view.php";'; 
		echo '</script>'; 
	}	

}

if( isset($_GET['tocart']) || isset($_REQUEST['id'])){
?>
<h1><?= $picture['nmphoto'] ?></h1>
<?php
echo "Autor: ".$picture['auphoto']."<br/>Description: ".$picture['desc']."<br/>";
echo "<img style='max-width:600px' src='./gallery/".$picture['fl']."' alt='".$picture['nmphoto']."' />";
?>
			<br/>&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="view.php?id=<?= $picture['_id']?>&tocart=<?= $picture['_id'] ?>"' value="Select"/>
<?php }?>
			&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="gallery.php?show=all"' value="back"/>
		

<?php
include 'cart.php';
?>



            </div>
        </div>
		<?php
			include('futer.htm'); 
		?>	
    </div>
 </body>
</html>
