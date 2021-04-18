<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Model;

class Usuarios extends BaseController
{
	public function index()
	{   
        $model = new UserModel();
        $data = [
            'title' => 'Usuários',
            'usuarios' => $model->orderBY('id', 'ASC')->paginate(3),
            'pager' => $model->pager,
            'msg' => ''
        ];

		echo view('backend/templates/html-header', $data);
		echo view('backend/templates/header');
		echo view('backend/pages/usuarios');
        echo view('backend/templates/footer');
		echo view('backend/templates/html-footer');

	}

    public function gravar()
    {

        $model = new UserModel();

        helper('form');

        if($this->validate([
            'user' => ['label' => 'Usuários', 'rules' => 
            'required|min_length[3]|is_unique[usuarios.user]'],

            'senha' => ['label' => 'Senha', 'rules' => 
            'required|min_length[3]']
        ])){

            $user = $this->request->getVar('user');
            $senha = $this->request->getVar('senha');
            $senhaCripto = md5($senha);

            $model->save([
                'user' => $user,
                'senha' => $senhaCripto
            ]);

            $data = [
                'title' => 'Usuários',
                'usuarios' => $model->orderBY('id', 'ASC')->paginate(3),
                'pager' => $model->pager,
                'msg' => 'Usuario Cadastrado com Sucesso!'
            ];

            echo view('backend/templates/html-header', $data);
            echo view('backend/templates/header');
            echo view('backend/pages/usuarios');
            echo view('backend/templates/footer');
            echo view('backend/templates/html-footer'); 

        }else{

            $data = [
                'title' => 'Usuários',
                'usuarios' => $model->orderBY('id', 'ASC')->paginate(3),
                'pager' => $model->pager,
                'msg' => 'Erro ao Cadastrar o Usuário!'
            ];

            echo view('backend/templates/html-header', $data);
            echo view('backend/templates/header');
            echo view('backend/pages/usuarios');
            echo view('backend/templates/footer');
            echo view('backend/templates/html-footer');

        }

    }

    public function excluir($id = null){
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/usuarios'));
    }

    public function editarSenha(){
        $model = new UserModel();

        $id = $this->request->getVar('id');
        $senha = $this->request->getVar('senha');
        $senhaCripto = md5($senha);
        
        $model->save([
            'id' => $id,
            'senha' => $senhaCripto
        ]);
        
        return redirect()->to(base_url('admin/usuarios'));   
    }
	//--------------------------------------------------------------------

}
