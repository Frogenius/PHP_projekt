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
						<input type="button" onClick='location.href="anketa"' value="Registracia"/>
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
<script type="text/javascript"> 
function getphotos(f){
            var name = f.value; 
	$.ajax({
	  type: 'POST',
	  url: '/mvc/web/find_srv',
	  data: 'spfoto='+name,
	  success: function(data){
		$('#seekphoto').html(data);
	  }
	});	
}

function getmyphotos(f){   
	$.ajax({
	  type: 'POST',
	  url: '/mvc/web/mygallery',
	  data: '', 
	  success: function(data){
		$('#seekphoto').html(data);
	  }
	});	
}

function getallphotos(f){   
	$.ajax({
	  type: 'POST',
	  url: '/mvc/web/photos',
	  data: '', 
	  success: function(data){
		$('#seekphoto').html(data);
	  }
	});	
}

function getselectphotos(f){   
	$.ajax({
	  type: 'POST',
	  url: '/mvc/web/selectphotos',
	  data: '', 
	  success: function(data){
		$('#seekphoto').html(data);
	  }
	});	
}
</script>


		&nbsp;&nbsp;&nbsp;<input type="button" onClick = "getallphotos(this)" value="Show all"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick = "getmyphotos(this)" value="Show my"/>
		&nbsp;&nbsp;&nbsp;<input type="button" onClick = "getselectphotos(this)" value="Show choose"/>
		
		<div id="form_anketa">
			<form id="pfind" method="POST" action="#">		
			
				Seek by name photo:  <input id="sphoto" name="sphoto" type="text" onkeyup = "getphotos(this)" placeholder="name photo" /> 
			</form>
		</div>
		
			<div id="seekphoto" style="position: relative;  height:100%; width:100%; margin-right: auto;">
                    <?php dispatch($routing, '/photos') ?>

            </div>
        </div>

	</div>

		


</body>
</html>
