<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VeiculoModel;
use App\Models\CategoriaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Veiculos extends BaseController
{
    protected $veiculoModel;
    protected $categoriaModel;
    
    public function __construct()
    {
        $this->veiculoModel = new VeiculoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    
    /**
     * Exibe a lista de veículos com opções de filtro
     */
    public function index()
    {
        $filtros = [
            'marca' => $this->request->getGet('marca'),
            'modelo' => $this->request->getGet('modelo'),
            'ano' => $this->request->getGet('ano'),
            'cor' => $this->request->getGet('cor'),
            'categoria_id' => $this->request->getGet('categoria_id'),
            'status' => $this->request->getGet('status')
        ];
        
        $data = [
            'titulo' => 'Gestão de Veículos',
            'veiculos' => $this->veiculoModel->buscarComFiltros($filtros),
            'categorias' => $this->categoriaModel->findAll(),
            'filtros' => $filtros
        ];
        
        return view('veiculos/index', $data);
    }
    
    /**
     * Exibe o formulário para criar um novo veículo
     */
    public function novo()
{
    $veiculos = $this->veiculoModel->findAll();

    $data = [
        'titulo' => 'Cadastrar Novo Veículo',
        'categorias' => $this->categoriaModel->getDropdownList(),
        'veiculos' => $veiculos,  // Adicionado aqui
    ];

    return view('veiculos/form', $data);
}

    
    /**
     * Processa o formulário de criação de veículo
     */
 public function criar()
{
    $dados = $this->request->getPost();
    if ($this->veiculoModel->insert($dados)) {
        return redirect()->to('veiculos')
                         ->with('success', 'Veículo cadastrado com sucesso.');
    } else {
        return redirect()->back()->withInput()
                         ->with('errors', $this->veiculoModel->errors());
    }
}
    
    /**
     * Exibe o formulário para editar um veículo existente
     */
    public function editar($id = null)
    {
        $veiculo = $this->veiculoModel->find($id);
        
        if ($veiculo === null) {
            throw new PageNotFoundException('Veículo não encontrado com ID: ' . $id);
        }
        
        $data = [
            'titulo' => 'Editar Veículo',
            'veiculo' => $veiculo,
            'categorias' => $this->categoriaModel->getDropdownList()
        ];
        
        return view('veiculos/form', $data);
    }
    
    /**
     * Processa o formulário de edição de veículo
     */
    public function atualizar($id = null)
    {
        if ($id === null) {
            return redirect()->to('/veiculos')
                ->with('error', 'ID do veículo não fornecido.');
        }
        
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            
            if ($this->veiculoModel->update($id, $data)) {
                return redirect()->to('/veiculos')
                    ->with('mensagem', 'Veículo atualizado com sucesso.');
            } else {
                return redirect()->back()
                    ->with('errors', $this->veiculoModel->errors())
                    ->withInput();
            }
        }
        
        return redirect()->to('/veiculos');
    }
    
    /**
     * Exibe a página de confirmação para excluir um veículo
     */
    public function confirmarExclusao($id = null)
    {
        $veiculo = $this->veiculoModel->find($id);
        
        if ($veiculo === null) {
            throw new PageNotFoundException('Veículo não encontrado com ID: ' . $id);
        }
        
        // Verificar se o veículo está em alguma locação ativa
        // Implementar lógica quando o modelo de locação estiver pronto
        
        $data = [
            'titulo' => 'Confirmar Exclusão',
            'veiculo' => $veiculo
        ];
        
        return view('veiculos/excluir', $data);
    }
    
    /**
     * Processa a exclusão de um veículo
     */
    public function excluir($id = null)
    {
        if ($id === null) {
            return redirect()->to('/veiculos')
                ->with('error', 'ID do veículo não fornecido.');
        }
        
        if ($this->veiculoModel->delete($id)) {
            return redirect()->to('/veiculos')
                ->with('mensagem', 'Veículo excluído com sucesso.');
        } else {
            return redirect()->to('/veiculos')
                ->with('error', 'Não foi possível excluir o veículo.');
        }
    }
    
    /**
     * Exibe detalhes de um veículo específico
     */
    public function detalhes($id = null)
    {
        $veiculo = $this->veiculoModel->find($id);
        
        if ($veiculo === null) {
            throw new PageNotFoundException('Veículo não encontrado com ID: ' . $id);
        }
        
        // Buscar categoria do veículo
        $categoria = $this->categoriaModel->find($veiculo['categoria_id']);
        
        $data = [
            'titulo' => 'Detalhes do Veículo',
            'veiculo' => $veiculo,
            'categoria' => $categoria
        ];
        
        return view('veiculos/detalhes', $data);
    }
    
    /**
     * Atualiza o status de um veículo
     */
    public function atualizarStatus($id = null)
    {
        if ($id === null || !$this->request->getPost('status')) {
            return redirect()->to('/veiculos')
                ->with('error', 'Dados insuficientes para atualizar o status.');
        }
        
        $status = $this->request->getPost('status');
        
        if ($this->veiculoModel->atualizarStatus($id, $status)) {
            return redirect()->to('/veiculos')
                ->with('mensagem', 'Status do veículo atualizado com sucesso.');
        } else {
            return redirect()->to('/veiculos')
                ->with('error', 'Não foi possível atualizar o status do veículo.');
        }
    }
}
