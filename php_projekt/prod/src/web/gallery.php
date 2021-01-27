<?php 
session_start(); 
	
	if (isset($_COOKIE['youname']) && isset($_COOKIE['userid'])&& empty( $_GET["add"])&&($_COOKIE['youname']!='Guest') ) {  
		$_SESSION['youname'] = $_COOKIE['youname'];
		$_SESSION['userid'] = $_COOKIE['userid'];	
		if (isset($_COOKIE['cartp']) )
			$_SESSION['cartp'] = unserialize($_COOKIE['cartp']);			
	}else if (!empty( $_GET["add"]) ){
		setcookie("youname", $_SESSION['youname'], time() + 60 * 60 * 24 * 5, "/"); //5 days
		setcookie("userid", $_SESSION['userid'] , time() + 60 * 60 * 24 * 5, "/"); //5 days	
		if (isset($_COOKIE['cartp']))
			$_SESSION['cartp'] = unserialize($_COOKIE['cartp']);
	}else{
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';
		$_SESSION['cartp'] = [];		
	}	
	if (!empty( $_GET["exit"]) ){
		$_SESSION = array();
		setcookie("youname", '', time() - 60 * 60 * 24 * 5, '/');
		setcookie("userid", '', time() - 60 * 60 * 24 * 5, '/');
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';	
		$_SESSION['cartp'] = [];
	}	
	
	
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
	
	</head>


 
 
 <body onload="onloadform()">
    <div class="pagec">
		<?php
			include_once('navi.htm'); 
		?> 	
		<div id="hellow_myname" class="hellow_myname" >
				<div id="hiname"></div>
				<form id="myform" action="gallery.php" method="POST">	
					<?php if (empty( $_SESSION['youname']) || ($_SESSION['youname']==='Guest') ){?>					
						<input id="youname" name="youname" type="text" placeholder="Name" /> 
						<input id="youpass" name="youpass" type="password" placeholder="password"/> 
						<input type="submit" onclick="true;" value="ok"/>
						Nadarzyce jeśli<br /> jesteśmy nieznajome : <br /> 
						<input type="button" onClick='location.href="anketa.php"' value="Registracia"/>
					<?php }else{?>
						<input type="button" onClick='location.href="gallery.php?exit=true"' value="Exit"/>
					<?php }?>					
				</form>
		</div>	
		<script type="text/javascript"> 
			snameinp("<?= $_SESSION['youname']?>", "<?= $_SESSION['userid']?>") ;
		</script>
        <div class="content1">
            <div class="content_in">		
		<?php	
			
		require_once 'functions.php';
		use MongoDB\BSON\ObjectID;
		$db = get_db();			
		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {				
			if (!empty($_POST['youname']) &&
				!empty($_POST['youpass'])
			) {
				$name=$_POST['youname']; 
				$password=md5($_POST['youpass']+$_POST['youname'] );
				
				$query = [
					'name' => $name,
					'password' => $password
				];			
			
				$user = $db->members->findOne($query);
				if ($user) {
					//echo $user['name'].$user['_id']."Есть такой!<br/>";
					$_SESSION['youname'] = $name;					
					$_SESSION['userid'] = $user['_id'];					

					if (!empty($_SESSION['userid'])){
						echo '<script type="text/javascript">'; 
						echo 'window.location.href="gallery.php?add=1";'; 
						echo '</script>'; 
						
					}					
			
				}
			}
		}
		if (!empty( $_SESSION['youname']) &&  ($_SESSION['youname']!='Guest')){?>	
				<button onClick='location.href="upload.php"'>Upload photo</button>	
		<?php }?>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="gallery.php?show=all"' value="Show all"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="gallery.php?show=my"' value="Show my"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="view.php"' value="Show choose"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="find.php"' value="Seek by name photo"/>
		
			
<?php

if (file_exists($uploaddir)) {
   

	$auid=$_SESSION['userid'];
	$auphoto=$_SESSION['youname'];

	$query = [
		'auphoto' => $auphoto
	];
	$queryAll = ['$or'=>[
		['auphoto' => $auphoto],
		['privat'=>'2'] ]
	];
	
	
	
	if (!empty( $_GET["show"]) ){		
		if($_GET["show"]==='my')
			$photos = $db->gallery->find($query);
		else if($_GET["show"]==='choose')
			$photos = $db->gallery->find($query);
		else
			$photos = $db->gallery->find($queryAll); //ALL
	}else
		$photos = $db->gallery->find($queryAll); //ALL GUEST
	
	
				
	echo "<table width='100%'>";
	foreach ($photos as $picture): 
		echo "<tr><td>";
		?><a href="view.php?id=<?= $picture['_id'] ?>"><img src="/gallery/<?= $picture['tm']?>" alt="<?= $picture['nmphoto']?>" /></a>	<?php
		echo "</td><td>";
		echo "Autor: ".$picture['auphoto']."<br/>Name: ".$picture['nmphoto']."<br/>Description: ".$picture['desc']."<br/>Privacy: ";
		if($picture['privat']==='2')
			echo "Public";
		else
			echo "Private";		
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