<!DOCTYPE html>
<html>
<head>
    <title>Photos</title>
    <?php include "includes/head.inc.php"; ?>
</head>
<body onload="onloadform()">
	<?php
		include_once('../../navi.htm'); 
	?> 	
		<div id="hellow_myname" class="hellow_myname" >
				<div id="hiname"></div>
				<form id="myform" action="/gallery.php" method="POST">	
					<?php if (empty( $_SESSION['youname']) || ($_SESSION['youname']==='Guest') ){?>					
						<input id="youname" name="youname" type="text" placeholder="Name" /> 
						<input id="youpass" name="youpass" type="password" placeholder="password"/> 
						<input type="submit" onclick="true;" value="ok"/>
						Nadarzyce jeśli<br /> jesteśmy nieznajome : <br /> 
						<input type="button" onClick='location.href="gallery"' value="Registracia"/>
					<?php }else{?>
						<input type="button" onClick='location.href="gallery?exit=true"' value="Exit"/>
					<?php }?>					
				</form>
		</div>	
		<script type="text/javascript"> 
			snameinp("<?= $_SESSION['youname']?>", "<?= $_SESSION['userid']?>") ;
		</script>		
		<?php
			include('../../futer.htm'); 
		?>
        <div class="content1">
            <div class="content_in">

			
			
			

				<div id="hellow" class="hellow" >
					<div id="form_anketa">
						<form action="anketa" method ="POST">
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
						<br/><br/><br/>
						<?php 
							if (!empty( $_SESSION['youname']) && ($_SESSION['youname']==='Irina') ){	
						
								dispatch($routing, '/members') 	;	
					
							}  ?>
					</div>        

				 </div>

				<br/><br/><br/><br/><br/><br/>			

            </div>
        </div>



		


</body>
</html>
