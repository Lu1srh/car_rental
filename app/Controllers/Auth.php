<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Auth extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        return view('auth/login');  // caminho correto para a view
    }

   public function login()
{
    $email = $this->request->getPost('email');
    $senha = $this->request->getPost('senha');

    $usuario = $this->usuarioModel->where('email', $email)->first();

    if ($usuario && $senha === $usuario['senha']) {
        session()->regenerate();
        session()->set([
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'nivel_acesso' => $usuario['nivel_acesso'],
            'logado' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    return redirect()->back()->with('error', 'Credenciais inválidas');
}

public function logout()
{
    session()->destroy();
    return redirect()->to('/login')->with('mensagem', 'Logout realizado com sucesso.');
}


}
