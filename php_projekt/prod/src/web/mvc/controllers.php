<?php
require_once 'business.php';
require_once 'controller_utils.php';

function gallery(&$model)
{
    $gallery = get_gallery();

    $model['gallery'] = $gallery;

    return 'gallery_view';
}
function mygallery(&$model)
{
	$model['photos'] = get_myphotos();
    return 'partial/find_srv_view';
	    
}
function photos(&$model)
{
	$model['photos'] = get_photos();
    return 'partial/find_srv_view';
	    
}
function find_srv(&$model)
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['spfoto'])) {
        $spfoto = $_POST['spfoto'];
		$model['photos'] = get_findphoto($spfoto);
		return 'partial/find_srv_view';
	}	
	    
}
function selectphotos(&$model)
{
	$model['photos'] = get_photos();
    return 'partial/cartp_view';
	    
}
function photo(&$model)
{
	
	if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($picture = get_photo($id)) {
            $model['picture'] = $picture;

            return 'photo_view';
        }
    }

    http_response_code(404);
    exit;

	    
}
function anketa(&$model)
{
	
		if (!empty($_GET['del'])) {
			del_member($_GET['del']);
		}
	
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (!empty($_POST['youname']) &&
			!empty($_POST['password']) &&
			!empty($_POST['password2']) &&
			!empty($_POST['email'])) {
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
				$user=is_autor($query);
				if (!$user){
					add_autor($anketa);
					$user=is_autor($query);
					if ($user){
						$_SESSION['youname'] = $name;					
						$_SESSION['userid'] = $user['_id'];					
						setcookie("youname", $_SESSION['youname'], time() + 60 * 60 * 24 * 5, "/"); //5 days
						setcookie("userid", $_SESSION['userid'] , time() + 60 * 60 * 24 * 5, "/"); //5 days	
						if (!empty($_SESSION['userid'])){
							return 'redirect:gallery';							
						}							
						
					}						
				}
			}
		}
	}
	
	$model['members'] = get_members();
    return 'anketa_view';
	    
}
function members(&$model)
{
	$model['members'] = get_members();
    return 'partial/members_view';
	    
}
