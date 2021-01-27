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
		<link type="text/css" href="./js/jquery-ui.css" rel="stylesheet" />
	
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
<script type="text/javascript"> 
function getphotos(f){
            var name = f.value; 
	$.ajax({
	  type: 'POST',
	  url: 'find_srv.php',
	  data: 'spfoto='+name,
	  success: function(data){
		$('#seekphoto').html(data);
	  }
	});

	
}
</script>
			
		<?php	
			
		require_once 'functions.php';
		use MongoDB\BSON\ObjectID;
		$db = get_db();			
		


		
		if (!empty( $_SESSION['youname']) &&  ($_SESSION['youname']!='Guest')){?>	
				<button onClick='location.href="upload.php"'>Upload photo</button>	
		<?php }?>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="gallery.php?show=all"' value="Show all"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="gallery.php?show=my"' value="Show my"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick='location.href="view.php"' value="Show choose"/>
		
		<div id="form_anketa">
			<form id="pfind" method="POST" action="#">		
			
				Seek by name photo:  <input id="sphoto" name="sphoto" type="text" onkeyup = "getphotos(this)" placeholder="name photo" /> 
			</form>
		</div>
			
                <div id="seekphoto" style="position: relative;  height:100%; width:100%; margin-right: auto;">
                    <br/>
					No photo
                    <br/>
                    !!!
                </div>	

            </div>
        </div>
		<?php
			include('futer.htm'); 
		?>
    </div>

 </body> 
</html>