<?php 
session_start(); 
?>
<?php	
	if ( !empty( $_SESSION['youname']) && !empty( $_SESSION['userid'])){
		if (!empty( $_GET["add"]) ){
			setcookie("youname", $_SESSION['youname'], time() + 60 * 60 * 24 * 5, "/"); //5 days
			setcookie("userid", $_SESSION['userid'] , time() + 60 * 60 * 24 * 5, "/"); //5 days	
			$_SESSION['cartp'] = [];
			setcookie("cartp", null , time() + 60 * 60 * 24 * 5, "/"); //5 days	
		}
	}else{
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';
		$_SESSION['cartp'] = [];	
		setcookie("cartp", null , time() + 60 * 60 * 24 * 5, "/"); //5 days		
	}	
	if (!empty( $_GET["exit"]) ){
		$_SESSION = array();
		setcookie("youname", '', time() - 60 * 60 * 24 * 5, '/');
		setcookie("userid", '', time() - 60 * 60 * 24 * 5, '/');
		$_SESSION['youname'] = 'Guest';
		$_SESSION['userid'] = '000';	
		$_SESSION['cartp'] = [];
		setcookie("cartp", null , time() + 60 * 60 * 24 * 5, "/"); //5 days
	}	
	
	

?>
<!DOCTYPE html>
<html>
 <head>
       <title>Rock clambing</title>                               
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css"/>
        <link href="./js/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./js/myscript.js"></script>
 </head>
 <body onload="onloadAnketa()">
 <div class="pagec">
		<?php
			include('navi.htm'); 
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
						<input type="button" onClick='location.href="anketa.php?exit=true"' value="Exit"/>
					<?php }?>					
				</form>
		</div>	
		<script type="text/javascript"> 
			snameinp("<?= $_SESSION['youname']?>", "<?= $_SESSION['userid']?>") ;
		</script>	
		
    <div class="content">
        <div class="content_in">
<?php
require_once 'functions.php';

use MongoDB\BSON\ObjectID;
$db = get_db();

$anketa = [
    'name' => null,
    'password' => null,
    'email' => null,
    'tel' => null,	
    'male' => false,	
    'experience' => false,    	
    '_id' => null
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {	
	if (!empty($_POST['youname']) &&
        !empty($_POST['password']) &&
		!empty($_POST['password2']) &&
        !empty($_POST['email'])
    ) {
		if ($_POST['password']===$_POST['password2']){
			
			$name=$_POST['youname']; 
			$password=md5($_POST['password']+$_POST['youname']);
			$email=$_POST['email'];
			$tel=$_POST['tel'];
			if ( isset($_POST['fm']) ) {
				if	($_POST['fm']=='m')
					$male=true; 
				else 
					$male=false;
			}else
				$male=false;
			if ( isset($_POST['expert']) ) {
				if ($_POST['expert']=='on')
					$experience=true; 
				else 
					$experience=false;
			}else
				$experience=false;


			$anketa = [
				'name' => $name,
				'password' => $password,
				'email' => $email,
				'tel' => $tel,	
				'male' => $male,	
				'experience' => $experience
			];
			
			$query = [
				'name' => $name,
				//'email' => $email
			];

			$user = $db->members->findOne($query);

			if ($user) {
				echo $user['name']." - has already!<br/>";
			} else {
				//echo "Нет такого!<br/>";
				if (empty($_POST['id'])) {
					$db->members->insertOne($anketa);
					echo $name."-Registered!!!<br/>";
					
					$query = [
							'name' => $name,
							'email' => $email
					];
					$user = $db->members->findOne($query);
					if ($user) {					
						$_SESSION['youname'] = $name;					
						$_SESSION['userid'] = $user['_id'];					

						if (!empty($_SESSION['userid'])){
							echo '<script type="text/javascript">'; 
							echo 'window.location.href="anketa.php?add=1";'; 
							echo '</script>'; 
							
						}
					}						
				} else {
					
				}
			}	
			
		}else
			echo "Passwords do not match!<br/>";
	}else
		echo "not all fields are filled!<br/>";
}else{
	echo "Wait...<br/>";
}		

			
			
?>
            <div id="hellow" class="hellow" >
                <div id="form_anketa">
                    <form action="anketa.php" method ="POST">
			                Zgłoszenie do wapółzawodnictwa :  <br/> 
                        <table>
                            <tr><td>Firstname*:</td><td><input class="input_f" id="youname" name="youname" type="text" onchange="fieldAnketa(id,value)"/></td></tr>
                            <tr><td>E-mail*:</td><td><input class="input_f" id="email" name="email" type="email" placeholder="sample@gmail.com" onchange="fieldAnketa(id,value)"  value=""/></td></tr>
                            <tr><td>Phone:</td><td><input class="input_f" id="tel" name="tel" type="tel" placeholder="+7 XXX XXXXXXX" onchange="fieldAnketa(id,value)" /></td></tr>
                            <tr><td>Male:</td><td><input class="input_f" id="fm1" type="radio" name="fm" value="m" onchange="fieldAnketa(id,value)" /></td></tr>
                            <tr><td>Femail:</td><td><input class="input_f" id="fm2" type="radio" name="fm" value="f" onchange="fieldAnketa(id,value)" /></td></tr>
                            <tr><td>I have an experience:</td><td><input class="input_f" id="expert" name="expert" type="checkbox" onchange="fieldAnketa(id,value)" /></td></tr>
                            <tr><td>Password*:</td><td><input class="input_f" id="password" name="password" type="password"  /></td></tr>
							<tr><td>Repead password*:</td><td><input class="input_f" id="password2" name="password2" type="password"  /></td></tr>
                            <!--tr><td><img alt='' id="train" class="input_f train" src="./img/letter.png" onclick="sendletter(this.form)"/-->
							</td><td><input type="submit" value="REGISTRACIA"/></td>
                            </td><td><input type="reset" value="CLEAR"/></td></tr>
                        </table>
   
    
                    </form>
                </div>        

             </div>

            <br/><br/><br/><br/><br/><br/>
			
			<?php
			echo "Our friends<br>";
			echo "count:".($db->members->count()).":<br/>";
				$members = $db->members->find();
				foreach ($members as $member): 
					echo " ".$member['name']. ", ";
				endforeach;
				


			?>
    </div>
    </div>
     
    
		<?php
			include('futer.htm'); 
		?>




      </div> 
 </body>
</html>