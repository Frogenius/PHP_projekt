<?php 
session_start(); 
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
		<?php
			if (empty($_SESSION['userid'])){
				echo '<script type="text/javascript">'; 
				echo 'window.location.href="gallery.php";'; 
				echo '</script>'; 	
				
			}
				//header( 'Location: /gallery.php', true, 303 );
		?>
		<div class="content1">
            <div class="content_in">
		<div id="but1" style="position:absolute; right:155px; top:70px">
			<button onClick='location.href="alluploaded.php"'>Show all uploads...</button><br/>
			<button onClick='location.href="gallery.php"'>Go to gallery</button>
		</div>
		File upload: 	
		<form id="uplf" enctype="multipart/form-data" action="upload.php" method="POST">
			<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
			<input type="hidden" name="MAX_FILE_SIZE" value="1024000" />
			<!-- Название элемента input определяет имя в массиве $_FILES -->
			File select *: <input name="userfile" type="file" />(max 1Mb, JPG or PNG)<br/>
			Description:<br/>
			<textarea name="desc" rows="10" cols="50">ROCK CLAMBING</textarea><br/>
			Znak wodny: <input name="znwod" type="text" maxlength="10" size="10" value="  ROCK" /><br/>
			Tytuł * : <input id="nmphoto" name="nmphoto" type="text" maxlength="20" size="20" /><br/>
			<div style="position:relative; float:left;">Autor * :&nbsp;</div> <div style="position:relative; float:left;"><?=$_SESSION['youname']?></div>
			<input id="auphoto" name="auphoto" type="hidden" maxlength="50" size="50" />
			<input id="auid" name="auid" type="hidden" maxlength="50" size="50" value="<?=$_SESSION['userid']?>" /><br/>
			Show all: <input name="privat" id="privat1" type="radio" value="2" checked />			
			Private: <input name="privat" id="privat3" type="radio" value="0" /><br/>			
			<input type="submit" value="Send File" />
		</form>

<?php
	require_once 'functions.php';
	use MongoDB\BSON\ObjectID;
	$db = get_db();
			
		
	$photo_item = [			
			'nmphoto' => null,
			'auphoto' => null,
			'auid' => null,
			'desc' => null,	
			'znwod' => null,
			'privat' => 2,
			'tm' => null,
			'fl' => null,
			'orig' => null,			
			'_id' => null
		];
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {			
			//upload photo!!!
		if (file_exists($uploaddir)) {
			$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
			   // echo "Папка $uploaddir существует<br/>";
			   
			   
			if ($_FILES['userfile']['error'] == '2'){
					echo " Przekroczono rozmiar 1 MB: ".$_FILES['userfile']['name']."<br>";	
			}else if ($_FILES['userfile']['error'] == '7'){
					echo "Nie udało się zapisać na dysku: ".$_FILES['userfile']['name']."<br>";
			}else if ($_FILES['userfile']['error'] == '0'){	
				if (($_FILES['userfile']['type'] != '3')&&($_FILES['userfile']['type'] != '2')&&($_FILES['userfile']['type'] != "image/jpeg") &&($_FILES['userfile']['type'] != "image/png")){
						//echo " name: ".$_FILES['userfile']['name']."<br>";
						//echo " error: ".$_FILES['userfile']['error']."<br>";
						  //echo " type: ".$_FILES['userfile']['type']."<br>";
						echo " Sorry, we only allow uploading PNG or JPG images<br/>";  
				}else{
						
						
					if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
							echo "Attention attak!<br/>";
					} else {			
						echo "File was upload.<br/>";	
						$orig=	$_FILES['userfile']['name'];					
						list($oldwidth, $oldheight, $type) = getimagesize($uploadfile);			
						$newname="img".rand();	
						switch($type){
							case 2:
								$newname=$newname.".jpg";
								$im = imagecreatefromjpeg($uploadfile);
								break;			
							case 3:
								$newname=$newname.".png";
								$im = imagecreatefrompng($uploadfile);
								break;			
						}
						
						imageresizeTM($uploaddir."tm_".$newname,$uploadfile,200,100, $oldwidth, $oldheight, $type);
						$tmnewname='gallery/'."tm_".$newname;
						echo "<img src='$tmnewname'/> ";
						//echo $_POST['desc'];
							
							//file with water lable				
						
						$stamp = imagecreatetruecolor(120, 50);
						imagefilledrectangle($stamp, 0, 0, 120, 50, 0x0000FF);
						imagefilledrectangle($stamp, 3, 3, 117, 47, 0xFFFFFF);
						imagestring($stamp, 8, 15, 20, $_POST['znwod'], 0x0000FF);
						$sx = imagesx($stamp);
						$sy = imagesy($stamp);
						imagecopymerge($im, $stamp, imagesx($im) - $sx-40, imagesy($im) - $sy-40, 0, 0, imagesx($stamp), imagesy($stamp), 30);
						imagepng($im, $uploaddir."fl_".$newname);
						imagedestroy($im);
							
							
						$flnewname='gallery/'."fl_".$newname;
						echo "<img src='$flnewname' width='500'/> ";
						//echo $_POST['nmphoto'];
						
						//insert DB !!!				
	
	
						if (!empty($_POST['nmphoto']) &&
								!empty($_POST['nmphoto']) &&
								!empty($_POST['auphoto'])
							) {
							$nmphoto=$_POST['nmphoto']; 
							$auphoto=$_POST['auphoto'];
							$auid=$_POST['auid']+"";
							//echo "<br/>auid:".$auid."<br/>";	
							$desc=$_POST['desc'];
							$znwod=$_POST['znwod'];
							if ( isset($_POST['privat']) ) {					
								$privat=$_POST['privat']; 
							}else
								$privat=2;				
									
				
							$photo_item = [				
									'nmphoto' => $nmphoto,
									'auphoto' => $auphoto,
									'auid' => $auid,
									'desc' => $desc,	
									'znwod' => $znwod,
									'privat' => $privat,
									'tm' => "tm_".$newname,
									'fl' => "fl_".$newname,
									'orig' => $orig,										
							];		
				
							$query = [
									'auid' => $auid,
									'nmphoto' => $nmphoto
							];

							$photo = $db->gallery->findOne($query);

							if ($photo) {
								echo $photo['nmphoto'].$photo['_id']."OK file!<br/>";
							} else {
								//echo "Нет такого!<br/>";
								if (empty($_POST['id'])) {
									$db->gallery->insertOne($photo_item);
									//echo "Inserted!<br/>";
								} else {
										//$id = $_POST['id'];
										//$db->gallery->replaceOne(['_id' => new ObjectID($id)], $photo_item);
								}
							}				
							$photo = $db->gallery->findOne($query);				
							//echo "nmphoto:".($photo['nmphoto'])." : _ID:".($photo['_id'])." : auid:".($photo['auid'])."<br/>";					
					
						}else
							echo "Not all fields are filled out!<br/>";	
					
					}
				}	
					
			}else{
				echo "File missing or corrupt<br>";
			}						
						
		} else {
			echo "Folder $uploaddir is absent<br/>";
		}	

	}else{
		echo "Upload fail<br/>";
	} //no upload	

?>			

			


            </div>
        </div>
		<?php
			include('futer.htm'); 
		?>	
    </div>
 </body>
</html>