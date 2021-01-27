<?php 
session_start(); 
	
	
?><br/><br/>
<?php
require_once 'functions.php';
		use MongoDB\BSON\ObjectID;
		use MongoDB\BSON\Regex;
		$db = get_db();	
		
if ($_SERVER['REQUEST_METHOD'] === 'POST') {	
	if (!empty($_POST['spfoto'])) {
		$spfoto=$_POST['spfoto']; 
		echo " photos: ".$spfoto."<br/>";
		
		if (file_exists($uploaddir)) {
			$query = [
				"nmphoto" => new Regex($spfoto, 'i') 
			];
				//$photos = $db->gallery->find($query);				
			
			$photos = $db->gallery->find($query); 
			echo "<table width='100%'>";
			foreach ($photos as $picture): 
			if (( $picture['auphoto']===$_SESSION['youname']) || ($picture['privat']==2)){

				echo "<tr><td>";
				?><a href="view.php?id=<?= $picture['_id'] ?>"><img src="/gallery/<?= $picture['tm']?>" alt="<?= $picture['nmphoto']?>" /></a>	<?php
				echo "</td><td>";
				echo "Autor: ".$picture['auphoto']."<br/>Name: ".$picture['nmphoto']."<br/>Description: ".$picture['desc']."<br/>Privacy: ";
				if($picture['privat']==='2')
					echo "Public";
				else
					echo "Private";	
				echo "</td></tr>";
			}
			endforeach;
			echo "</table>";
		}	
		
	}else{
		echo "No photos";
	}
}