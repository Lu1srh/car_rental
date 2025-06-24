<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Clientes extends BaseController
{
    protected $clienteModel;
    
    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }
    
    /**
     * Exibe a lista de clientes com opções de filtro
     */
    public function index()
    {
        $filtros = [
            'nome' => $this->request->getGet('nome'),
            'cpf' => $this->request->getGet('cpf'),
            'email' => $this->request->getGet('email'),
            'cidade' => $this->request->getGet('cidade'),
            'estado' => $this->request->getGet('estado'),
            'ativo' => $this->request->getGet('ativo')
        ];
        
        $data = [
            'titulo' => 'Gestão de Clientes',
            'clientes' => $this->clienteModel->buscarComFiltros($filtros),
            'filtros' => $filtros,
            'estados' => $this->getEstadosBrasileiros()
        ];
        
        return view('clientes/index', $data);
    }
    
    /**
     * Exibe o formulário para criar um novo cliente
     */
    public function novo()
    {
        $data = [
            'titulo' => 'Cadastrar Novo Cliente',
            'estados' => $this->getEstadosBrasileiros()
        ];
        
        return view('clientes/form', $data);
    }
    
    /**
     * Processa o formulário de criação de cliente
     */
    public function criar()
{
    $dados = $this->request->getPost();

    if ($this->clienteModel->insert($dados)) {
        return redirect()->to('/clientes')
            ->with('success', 'Cliente cadastrado com sucesso.');
    } else {
        return redirect()->back()->withInput()
            ->with('errors', $this->clienteModel->errors());
    }
}
    /**
     * Exibe o formulário para editar um cliente existente
     */
   public function editar($id = null)
{
    $cliente = $this->clienteModel->find($id);
    if (!$cliente) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente não encontrado.');
    }

    return view('clientes/form', [
        'titulo' => 'Editar Cliente',
        'cliente' => $cliente,
        'estados' => $this->getEstadosBrasileiros(),
    ]);
}

    
    /**
     * Processa o formulário de edição de cliente
     */
    public function atualizar($id = null)
{
    if ($id === null) {
        return redirect()->to('/clientes')->with('error', 'ID do cliente não fornecido.');
    }

    $dados = $this->request->getPost();

    if (isset($dados['cpf'])) {
        $dados['cpf'] = preg_replace('/\D/', '', $dados['cpf']);
    }

    $dados['ativo'] = isset($dados['ativo']) ? 1 : 0;

    // Passa o id para o model usar na validação
    $this->clienteModel->setValidationRule('cpf', 'required|min_length[11]|max_length[14]|cpfUnico[' . $id . ']');

    if ($this->clienteModel->update($id, $dados)) {
        return redirect()->to('/clientes')->with('success', 'Cliente atualizado com sucesso.');
    } else {
        return redirect()->back()->with('errors', $this->clienteModel->errors())->withInput();
    }
}

    public function confirmarExclusao($id = null)
    {
        $cliente = $this->clienteModel->find($id);
        
        if ($cliente === null) {
            throw new PageNotFoundException('Cliente não encontrado com ID: ' . $id);
        }
        
        // Verificar se o cliente possui locações
        $historicoLocacoes = $this->clienteModel->buscarHistoricoLocacoes($id);
        $possuiLocacoes = !empty($historicoLocacoes);
        
        $data = [
            'titulo' => 'Confirmar Exclusão',
            'cliente' => $cliente,
            'possuiLocacoes' => $possuiLocacoes
        ];
        
        return view('clientes/excluir', $data);
    }
    
    public function excluir($id = null)
    {
        if ($id === null) {
            return redirect()->to('/clientes')
                ->with('error', 'ID do cliente não fornecido.');
        }
        
        // Verificar se o cliente possui locações
        $historicoLocacoes = $this->clienteModel->buscarHistoricoLocacoes($id);
        if (!empty($historicoLocacoes)) {
            return redirect()->to('/clientes')
                ->with('error', 'Não é possível excluir o cliente pois ele possui locações registradas.');
        }
        
        if ($this->clienteModel->delete($id)) {
            return redirect()->to('/clientes')
                ->with('mensagem', 'Cliente excluído com sucesso.');
        } else {
            return redirect()->to('/clientes')
                ->with('error', 'Não foi possível excluir o cliente.');
        }
    }
    
    /**
     * Exibe detalhes de um cliente específico
     */
    public function detalhes($id = null)
    {
        $cliente = $this->clienteModel->find($id);
        
        if ($cliente === null) {
            throw new PageNotFoundException('Cliente não encontrado com ID: ' . $id);
        }
        
        // Buscar histórico de locações do cliente
        $historicoLocacoes = $this->clienteModel->buscarHistoricoLocacoes($id);
        
        $data = [
            'titulo' => 'Detalhes do Cliente',
            'cliente' => $cliente,
            'endereco' => $this->clienteModel->formatarEndereco($cliente),
            'historicoLocacoes' => $historicoLocacoes
        ];
        
        return view('clientes/detalhes', $data);
    }

    public function desativar($id)
{
    $clienteModel = new \App\Models\ClienteModel();

    // Atualiza o campo 'ativo' para 0 (inativo)
    $clienteModel->update($id, ['ativo' => 0]);

    return redirect()->to('/clientes')->with('success', 'Cliente desativado com sucesso.');
}

    
    /**
     * Retorna a lista de estados brasileiros
     */
    private function getEstadosBrasileiros()
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        ];
    }
}
