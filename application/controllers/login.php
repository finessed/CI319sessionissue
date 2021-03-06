<?php 
class Login extends CI_Controller
{
	function __construct(){
		parent::__contruct();
		$this->load->model('login_model');
	}
	function index(){
		$this->load->view('login_view');
	}

	function auth(){
		$email = $this->input->post('email',TRUE);
		$password = md5($this->input->post('password',TRUE));
		$validate = $this->login_model->validate($email,$password);
		if($validate->num_rows() > 0){
			$data = $validate->row_array();
			$name = $data['user_name'];
			$email = $data['user_email'];
			$level = $data['user_level'];
			$sesdata = array(
				'username' => $name,
				'email' => $email,
				'level' => $level,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($sesdata);
			//login for superadmin
			if($level === '1'){
				redirect('page');
			}
			//login for admin
			elseif($level === '2'){
				redirect('page/admin')
			}
			else($level === '3'){
				redirect('page/nurse')
			}
			else{
				echo $this->session->set_flashdata('msg','Username or Password is wrong');
			}
		}
		function logout(){
			$this->session->sess_destroy();
			redirect('login';)
		}
	}
}
?>
