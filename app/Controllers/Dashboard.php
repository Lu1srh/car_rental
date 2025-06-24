<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VeiculoModel;
use App\Models\ClienteModel;
use App\Models\LocacaoModel;
use App\Models\UsuarioModel;

class Dashboard extends BaseController
{
    protected $veiculoModel;
    protected $clienteModel;
    protected $locacaoModel;
    protected $usuarioModel;
    
    public function __construct()
    {
        $this->veiculoModel = new VeiculoModel();
        $this->clienteModel = new ClienteModel();
        $this->locacaoModel = new LocacaoModel();
        $this->usuarioModel = new UsuarioModel();
    }
    
    /**
     * Exibe o painel administrativo
     */
    public function index()
    {
        // Verifica se o usuário está logado
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        // Contagem de registros para o dashboard
        $totalVeiculos = $this->veiculoModel->countAll();
        $veiculosDisponiveis = $this->veiculoModel->where('status', 'disponivel')->countAllResults();
        $veiculosLocados = $this->veiculoModel->where('status', 'locado')->countAllResults();
        $veiculosManutencao = $this->veiculoModel->where('status', 'manutencao')->countAllResults();
        
        $totalClientes = $this->clienteModel->countAll();
        $clientesAtivos = $this->clienteModel->where('ativo', 1)->countAllResults();
        
        $totalLocacoes = $this->locacaoModel->countAll();
        $locacoesAtivas = $this->locacaoModel->where('status', 'ativa')->countAllResults();
        $locacoesFinalizadas = $this->locacaoModel->where('status', 'finalizada')->countAllResults();
        $locacoesCanceladas = $this->locacaoModel->where('status', 'cancelada')->countAllResults();
        
        // Locações recentes
        $locacoesRecentes = $this->locacaoModel->buscarComFiltros([]);
        $locacoesRecentes = array_slice($locacoesRecentes, 0, 5); // Limita a 5 registros
        
        $data = [
            'titulo' => 'Painel Administrativo',
            'totalVeiculos' => $totalVeiculos,
            'veiculosDisponiveis' => $veiculosDisponiveis,
            'veiculosLocados' => $veiculosLocados,
            'veiculosManutencao' => $veiculosManutencao,
            'totalClientes' => $totalClientes,
            'clientesAtivos' => $clientesAtivos,
            'totalLocacoes' => $totalLocacoes,
            'locacoesAtivas' => $locacoesAtivas,
            'locacoesFinalizadas' => $locacoesFinalizadas,
            'locacoesCanceladas' => $locacoesCanceladas,
            'locacoesRecentes' => $locacoesRecentes
        ];
        
        return view('dashboard/index', $data);
    }
    
    /**
     * Exibe a página de gerenciamento de usuários (apenas para administradores)
     */
    public function usuarios()
    {
        // Verifica se o usuário está logado e é administrador
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        if (session()->get('nivel_acesso') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        
        $filtros = [
            'nome' => $this->request->getGet('nome'),
            'email' => $this->request->getGet('email'),
            'nivel_acesso' => $this->request->getGet('nivel_acesso'),
            'ativo' => $this->request->getGet('ativo')
        ];
        
        $data = [
            'titulo' => 'Gerenciamento de Usuários',
            'usuarios' => $this->usuarioModel->buscarComFiltros($filtros),
            'filtros' => $filtros
        ];
        
        return view('dashboard/usuarios', $data);
    }
    
    /**
     * Exibe o formulário para criar um novo usuário (apenas para administradores)
     */
    public function novoUsuario()
    {
        // Verifica se o usuário está logado e é administrador
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        if (session()->get('nivel_acesso') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        
        $data = [
            'titulo' => 'Cadastrar Novo Usuário'
        ];
        
        return view('dashboard/usuario_form', $data);
    }
    
    /**
     * Processa o formulário de criação de usuário (apenas para administradores)
     */
    public function criarUsuario()
{
    // Verifica se o usuário está logado e é admin
    if (!session()->get('logado')) {
        return redirect()->to('/login');
    }
    
    if (session()->get('nivel_acesso') !== 'admin') {
        return redirect()->to('/dashboard')
            ->with('error', 'Acesso negado. Você não tem permissão para realizar esta ação.');
    }

    // Só aceita requisição POST
    if ($this->request->getMethod() !== 'post') {
        return redirect()->to('/dashboard/novoUsuario');
    }

    $dados = $this->request->getPost();

    // Validação dos dados
    $validation = \Config\Services::validation();

    $validation->setRules([
        'nome'        => 'required|min_length[3]',
        'email'       => 'required|valid_email|is_unique[usuarios.email]',
        'senha'       => 'required|min_length[6]',
        'nivel_acesso'=> 'required|in_list[admin,usuario]',
        'ativo'       => 'permit_empty|in_list[0,1]'
    ]);

    if (!$validation->run($dados)) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Hash da senha
    $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

    // Se checkbox ativo não enviado, define como 0
    if (!isset($dados['ativo'])) {
        $dados['ativo'] = 0;
    }

    // Insere no banco
    if ($this->usuarioModel->insert($dados)) {
        return redirect()->to('/dashboard')
                         ->with('success', 'Usuário cadastrado com sucesso.');
    } else {
        return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
    }
}

    


    /**
     * Exibe o formulário para editar um usuário existente (apenas para administradores)
     */
    public function editarUsuario($id = null)
    {
        // Verifica se o usuário está logado e é administrador
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        if (session()->get('nivel_acesso') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        
        $usuario = $this->usuarioModel->find($id);
        
        if ($usuario === null) {
            return redirect()->to('/dashboard/usuarios')
                ->with('error', 'Usuário não encontrado.');
        }
        
        $data = [
            'titulo' => 'Editar Usuário',
            'usuario' => $usuario
        ];
        
        return view('dashboard/usuario_form', $data);
    }
    
    /**
     * Processa o formulário de edição de usuário (apenas para administradores)
     */
    public function atualizarUsuario($id = null)
    {
        // Verifica se o usuário está logado e é administrador
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        if (session()->get('nivel_acesso') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
        
        if ($id === null) {
            return redirect()->to('/dashboard/usuarios')
                ->with('error', 'ID do usuário não fornecido.');
        }
        
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            
            // Trata o checkbox de ativo
            $data['ativo'] = isset($data['ativo']) ? 1 : 0;
            
            // Se a senha estiver vazia, remove do array para não atualizar
            if (empty($data['senha'])) {
                unset($data['senha']);
            }
            
            if ($this->usuarioModel->update($id, $data)) {
                return redirect()->to('/dashboard/usuarios')
                    ->with('mensagem', 'Usuário atualizado com sucesso.');
            } else {
                return redirect()->back()
                    ->with('errors', $this->usuarioModel->errors())
                    ->withInput();
            }
        }
        
        return redirect()->to('/dashboard/usuarios');
    }
    
    /**
     * Exibe a página de perfil do usuário logado
     */
    public function perfil()
    {
        // Verifica se o usuário está logado
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        $usuario = $this->usuarioModel->find(session()->get('id'));
        
        if ($usuario === null) {
            return redirect()->to('/dashboard')
                ->with('error', 'Usuário não encontrado.');
        }
        
        $data = [
            'titulo' => 'Meu Perfil',
            'usuario' => $usuario
        ];
        
        return view('dashboard/perfil', $data);
    }
    
    /**
     * Processa o formulário de atualização de perfil
     */
    public function atualizarPerfil()
    {
        // Verifica se o usuário está logado
        if (!session()->get('logado')) {
            return redirect()->to('/login');
        }
        
        $id = session()->get('id');
        
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            
            // Se a senha estiver vazia, remove do array para não atualizar
            if (empty($data['senha'])) {
                unset($data['senha']);
            }
            
            // Não permite alterar o nível de acesso pelo perfil
            unset($data['nivel_acesso']);
            
            // Não permite desativar o próprio usuário
            unset($data['ativo']);
            
            if ($this->usuarioModel->update($id, $data)) {
                // Atualiza os dados da sessão
                session()->set('nome', $data['nome']);
                if (isset($data['email'])) {
                    session()->set('email', $data['email']);
                }
                
                return redirect()->to('/dashboard/perfil')
                    ->with('mensagem', 'Perfil atualizado com sucesso.');
            } else {
                return redirect()->back()
                    ->with('errors', $this->usuarioModel->errors())
                    ->withInput();
            }
        }
        
        return redirect()->to('/dashboard/perfil');
    }
}
