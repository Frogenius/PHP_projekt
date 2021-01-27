<!DOCTYPE html>
<html>
<head>
    <title>Photo</title>
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
		
        <div class="content1">
            <div class="content_in">

				<br/>&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.history.back();" value="Back"/><br/><br/>
				<h1><?= $picture['nmphoto'] ?></h1>
				Autor:<?= $picture['auphoto'] ?><br/>
				Description:<?= $picture['auphoto'] ?><br/>
				<img style="max-width:600px" src="/gallery/<?= $picture['fl'] ?>" alt="<?= $picture['nmphoto'] ?>" />
			
			
				<br/>&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.history.back();" value="Back"/><br/><br/>
            </div>
        </div>



		<?php
			include('../../futer.htm'); 
		?>


</body>
</html>
