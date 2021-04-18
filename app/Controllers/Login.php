<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Login extends BaseController
{
	public function index()
	{
		$data['title'] = 'login_errors';
		
		echo view('backend/templates/html-header', $data);
		echo view('backend/pages/login');
		echo view('backend/templates/html-footer');
	}

	public function entrar(){
		$model = new UserModel();

		$user = $this->request->getVar('user');
		$senha = $this->request->getVar('senha');

		$data['usuarios'] = $model->getUser($user, $senha);

		if(empty($data['usuarios'])){
			return redirect()->to(base_url('login'));
		}else{
			$sessionData = [
				'user' => $data['usuarios']['user'],
				'logged_in' => TRUE
			];

			session()->set($sessionData);

			return redirect()->to(base_url('admin'));
		}
	}

	public function logout(){
		session()->destroy();
		return redirect()->to(base_url('login'));
	}
}
