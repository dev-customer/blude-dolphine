<?php if(!defined('DIR_APP')) die('Your have not permission');  
class User extends Module {  

	public $dirUp = '';

	function __construct(){ 
		$this->dirUp = DIR_UPLOAD.'/users/'; 
		$this->model('user/model/user');
	}
	function index(){ }		
	
	function register() 
	{
		if(!empty($_SESSION['id_user_frontend']) )
			$this->redirect(LINK_USER_ACCOUNT); 	
		else{
			if($_SERVER['REQUEST_METHOD'] == 'POST') 
				$this->save(); 
			else
				$this->view('user/view/userform');
		}
	}
	
	function login() { 
		global $mod;
		if(empty($_SESSION['id_user_frontend']) )
		{  
			if($_SERVER['REQUEST_METHOD']=='POST') 
			{  
				$row = $this->row('SELECT * FROM #__users WHERE email = "'.addslashes($_POST['email']) .'"');
				 
				if($row) {
					if($row['publish']==0){
						$_SESSION['message'] = USER_ERROR_ACCOUNT_LOCKED;
						$this->redirect(LINK_USER_LOGIN);						
					}
					else{
							if(encryptPwdUser($_POST['password'])== $row['password']){
								$_SESSION['isLoggedIn'] = true;
								$_SESSION['id_user_frontend'] = $row['id_user'];
								
								$this->query("UPDATE #__users SET last_connection=NOW(), ip='".$_SERVER['REMOTE_ADDR']."' WHERE id_user = ".$row['id_user']);
								$this->redirect(LINK_USER_ACCOUNT);
							}else{
								$_SESSION['message'] = LANG_USER_ERROR_ACCOUNT;
								$this->redirect(LINK_USER_LOGIN);
							} 
					}	
				}
				else{
					$_SESSION['message'] = USER_ERROR_ACCOUNT_NOT_EXISTS;
					$this->redirect(LINK_USER_LOGIN);
				}
			}
			$this->view('user/view/login');
		}else
			$this->redirect(LINK_USER_ACCOUNT);
	}
	
	function resetPwd() {
		if(empty($_SESSION['id_user_frontend']) ) 
			$this->view('user/view/resetPwd');
		else
			$this->redirect(LINK_USER_ACCOUNT);
	}		
	
	function logout() {		
		unset($_SESSION['isLoggedIn']);
		unset($_SESSION['id_user_frontend']);
		session_destroy();
		$this->redirect();
	}
	
	function account() {
		if(!empty($_SESSION['id_user_frontend']) ){  
			//check summit form
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$this->save(); 			
			}
			
			//data from $user 
			$this->view('user/view/account');
		}else
			$this->redirect(LINK_USER_LOGIN);
	}
	  
	 
	function save(){	
		extract($_POST);
		if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{   
			if(empty($email)) {
				$_SESSION['message'] = LANG_REQUIRE;
				$this->redirect(LINK_USER_REG);
			}
			else {			
					if(!$this->checkExistsEmail($email)) //CHECK LAI 2 TRUONG HOP NEW/UPDATE *******
					{
						
						include('lib/admin.php');
						 
						$img_type = $_FILES['image']['type'];
						$img_name = 'avt-'.time().'_'.substr(Module::Rewrite($_FILES['image']['name']), -30);
						$image_name = '';
						if(Admin::checkType($img_type)){
							$image_name = Admin::upload('image', $img_name , $this->dirUp);
							is_file($this->dirUp.$old_img) ? unlink($this->dirUp.$old_img) : '';
						}  
						 
						$model = new ModelUser();
						
						if($_POST['actExec']=='insertAccount')
						{
							$model->insert($image_name);  
							$_SESSION['message'] = USER_REGISTER_SUCCESS;
							$this->aRedirect(USER_REGISTER_SUCCESS, BASE_NAME);
						}
						else if($_POST['actExec']=='updateAccount'){
							$model->update($image_name);
							$_SESSION['message'] = USER_UPDATE_SUCCESS;
							$this->aRedirect(USER_UPDATE_SUCCESS, LINK_USER_ACCOUNT);
						} 
						
					}else{
						$_SESSION['message'] = USER_ERROR_EXISTS_EMAIL;
						$this->redirect(LINK_USER_REG);
					}
				}
		}else 
			$this->redirect(LINK_USER_ACCOUNT);
	} 
	 	
	function checkExistsEmail($email='')
	{	
		if(!empty($_SESSION['id_user_frontend']))
			$sql = "SELECT * FROM #__users WHERE email = '".$email."' AND id_user <> ".$_SESSION['id_user_frontend'];
		else
			$sql = "SELECT * FROM #__users WHERE email = '".$email."'";
		
		$num = $this->num($sql);  
		return $num > 0? true : false;
	}	

}

?>