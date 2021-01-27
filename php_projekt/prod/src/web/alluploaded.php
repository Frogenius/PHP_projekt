<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
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
 <body onload="onliname()">
    <div class="pagec">
		<?php
			include_once('navi.htm'); 
		?> 	
        <div class="content1">
            <div class="content_in">
		
			<div id="but1" style="position:relative; left:15px; top:-3px">
				<button onClick='location.href="upload.php"'>Back to upload form</button>
			</div>	
			<div style="position:relative; float:left;">Uploaded photo from :&nbsp;&nbsp; </div> <div id="hiname" style="position:relative; float:left;"></div>
			<br/>
<?php
require_once 'functions.php';
use MongoDB\BSON\ObjectID;
use MongoDB\Collection\update;
$db = get_db();
//$db->gallery->deleteMany(["auphoto" => 'Irina2']);



if (!empty( $_GET["delete"])){
	$delid=$_GET["delete"];
	$product = $db->gallery->findOne(['_id' => new ObjectID($delid)]);	
	if($product){
		if (file_exists($uploaddir.$product['tm']))
			unlink($uploaddir.$product['tm']);
		if (file_exists($uploaddir.$product['fl']))
			unlink($uploaddir.$product['fl']);
		if (file_exists($uploaddir.$product['orig']))
			unlink($uploaddir.$product['orig']);
		$db->gallery->deleteOne(['_id' => new ObjectID($delid)]);
		echo "Photo deleted : ".$product['nmphoto']." "."<br/>";
	}
}
if (!empty( $_GET["private"])){
	$private=$_GET["private"];
	$query=['_id' => new ObjectID($private)];
	$product = $db->gallery->findOne($query);	
	if($product){		
		$db->gallery->updateOne($query, ['$set' => ["privat" => 0]]);			
	}
}

if (!empty( $_GET["public"])){
	$public=$_GET["public"];
	$query=['_id' => new ObjectID($public)];
	$product = $db->gallery->findOne($query);	
	if($product){		
		$update = ['privat' => 2];
		$db->gallery->updateOne($query, ['$set' => ["privat" => 2]]);				
	}
}


if (file_exists($uploaddir)) {	
	$auid=$_SESSION['userid'];
	$auphoto=$_SESSION['youname'];
	
	$query = [
		'auphoto' => $auphoto
	];

	$photos = $db->gallery->find($query);
			
	echo "<table width='100%'>";
	foreach ($photos as $picture): 
		echo "<tr><td>";
		echo "<a href='./gallery/".$picture['fl']."'><img src='./gallery/".$picture['tm']."' alt='".$picture['nmphoto']."' /></a>";	
		echo "</td><td>";
		echo "Autor: ".$picture['auphoto']."<br/>Name: ".$picture['nmphoto']."<br/>Description: ".$picture['desc']."<br/>Privacy: ";
		if($picture['privat']==2){
			?><a href="alluploaded.php?private=<?= $picture['_id'] ?>">Public(change...)</a><?php			
		}else{
			?><a href="alluploaded.php?public=<?= $picture['_id'] ?>">Private(change...)</a><?php	
		}
		echo "</td><td>";		
		?><a href="alluploaded.php?delete=<?= $picture['_id'] ?>">Usuń /Delete</a><?php
		echo "</td></tr>";
	endforeach;
	echo "</table>";
    
   
} else {
    echo "Folder $uploaddir is absent<br/>";
}	
	


?>			

            </div>
        </div>
		<?php
			include('futer.htm'); 
		?>
    </div>
 </body>
</html>