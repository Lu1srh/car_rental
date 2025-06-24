<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LocacaoModel;
use App\Models\ClienteModel;
use App\Models\VeiculoModel;
use App\Models\CategoriaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Locacoes extends BaseController
{
    protected $locacaoModel;
    protected $clienteModel;
    protected $veiculoModel;
    protected $categoriaModel;
    
    public function __construct()
    {
        $this->locacaoModel = new LocacaoModel();
        $this->clienteModel = new ClienteModel();
        $this->veiculoModel = new VeiculoModel();
        $this->categoriaModel = new CategoriaModel();
    }
    
    /**
     * Exibe a lista de locações com opções de filtro
     */
    public function index()
    {
        $filtros = [
            'cliente_id' => $this->request->getGet('cliente_id'),
            'veiculo_id' => $this->request->getGet('veiculo_id'),
            'status' => $this->request->getGet('status'),
            'data_inicio' => $this->request->getGet('data_inicio'),
            'data_fim' => $this->request->getGet('data_fim')
        ];
        
        $data = [
            'titulo' => 'Gestão de Locações',
            'locacoes' => $this->locacaoModel->buscarComFiltros($filtros),
            'filtros' => $filtros,
            'clientes' => $this->clienteModel->findAll(),
            'veiculos' => $this->veiculoModel->findAll()
        ];
        
        return view('locacoes/index', $data);
    }
    
    /**
     * Exibe o formulário para criar uma nova locação
     */
    public function nova()
    {
        $data = [
            'titulo' => 'Registrar Nova Locação',
            'clientes' => $this->clienteModel->where('ativo', 1)->findAll(),
            'veiculos' => $this->veiculoModel->where('status', 'disponivel')->findAll(),
            'categorias' => $this->categoriaModel->findAll()
        ];
        
        return view('locacoes/form', $data);
    }
    
    /**
     * Processa o formulário de criação de locação
     */



public function criar()
{
    $dados = $this->request->getPost();

    // Busca o veículo para pegar a categoria e o valor da diária
    $veiculo = $this->veiculoModel->find($dados['veiculo_id']);
    if (!$veiculo) {
        return redirect()->back()->withInput()
                         ->with('errors', ['Veículo não encontrado.']);
    }

    $categoria = $this->categoriaModel->find($veiculo['categoria_id']);
    if (!$categoria) {
        return redirect()->back()->withInput()
                         ->with('errors', ['Categoria do veículo não encontrada.']);
    }

    // Define o valor da diária no dados da locação
    $dados['valor_diaria'] = $categoria['valor_diaria'];

    // Calcula o valor total com base nas datas e valor da diária
    $dados['valor_total'] = $this->locacaoModel->calcularValorTotal(
        $dados['valor_diaria'],
        $dados['data_retirada'],
        $dados['data_devolucao_prevista']
    );

    // Define o status inicial da locação
    $dados['status'] = 'ativa';

    if ($this->locacaoModel->insert($dados)) {
        return redirect()->to('locacoes')
                         ->with('success', 'Locação cadastrada com sucesso.');
    } else {
        return redirect()->back()->withInput()
                         ->with('errors', $this->locacaoModel->errors());
    }
}


    
    /**
     * Exibe o formulário para registrar a devolução de um veículo
     */
    public function devolucao($id = null)
    {
        $locacao = $this->locacaoModel->find($id);
        
        if ($locacao === null) {
            throw new PageNotFoundException('Locação não encontrada com ID: ' . $id);
        }
        
        if ($locacao['status'] !== 'ativa') {
            return redirect()->to('/locacoes')
                ->with('error', 'Esta locação não está ativa e não pode ser devolvida.');
        }
        
        // Busca informações adicionais
        $cliente = $this->clienteModel->find($locacao['cliente_id']);
        $veiculo = $this->veiculoModel->find($locacao['veiculo_id']);
        
        $data = [
            'titulo' => 'Registrar Devolução',
            'locacao' => $locacao,
            'cliente' => $cliente,
            'veiculo' => $veiculo,
            'data_atual' => date('Y-m-d\TH:i')
        ];
        
        return view('locacoes/devolucao', $data);
    }
    
    /**
     * Processa o formulário de devolução
     */
    public function processarDevolucao($id = null)
    {
        if ($id === null) {
            return redirect()->to('/locacoes')
                ->with('error', 'ID da locação não fornecido.');
        }
        
        $locacao = $this->locacaoModel->find($id);
        
        if ($locacao === null) {
            throw new PageNotFoundException('Locação não encontrada com ID: ' . $id);
        }
        
        if ($locacao['status'] !== 'ativa') {
            return redirect()->to('/locacoes')
                ->with('error', 'Esta locação não está ativa e não pode ser devolvida.');
        }
        
        if ($this->request->getMethod() === 'post') {
            $data = [
                'data_devolucao_efetiva' => $this->request->getPost('data_devolucao_efetiva'),
                'observacoes_devolucao' => $this->request->getPost('observacoes_devolucao'),
                'status' => 'finalizada'
            ];
            
            // Calcula multa por atraso, se houver
            $data['multa_atraso'] = $this->locacaoModel->calcularMultaAtraso(
                $locacao['valor_diaria'],
                $locacao['data_devolucao_prevista'],
                $data['data_devolucao_efetiva']
            );
            
            if ($this->locacaoModel->update($id, $data)) {
                return redirect()->to('/locacoes')
                    ->with('mensagem', 'Devolução registrada com sucesso.');
            } else {
                return redirect()->back()
                    ->with('errors', $this->locacaoModel->errors())
                    ->withInput();
            }
        }
        
        return redirect()->to('/locacoes');
    }
    
    /**
     * Exibe detalhes de uma locação específica
     */
    public function detalhes($id = null)
    {
        $locacao = $this->locacaoModel->find($id);
        
        if ($locacao === null) {
            throw new PageNotFoundException('Locação não encontrada com ID: ' . $id);
        }
        
        // Busca informações adicionais
        $cliente = $this->clienteModel->find($locacao['cliente_id']);
        $veiculo = $this->veiculoModel->find($locacao['veiculo_id']);
        $categoria = $this->categoriaModel->find($veiculo['categoria_id']);
        
        $data = [
            'titulo' => 'Detalhes da Locação',
            'locacao' => $locacao,
            'cliente' => $cliente,
            'veiculo' => $veiculo,
            'categoria' => $categoria
        ];
        
        return view('locacoes/detalhes', $data);
    }
    
    /**
     * Exibe a página de confirmação para cancelar uma locação
     */
    public function confirmarCancelamento($id = null)
    {
        $locacao = $this->locacaoModel->find($id);
        
        if ($locacao === null) {
            throw new PageNotFoundException('Locação não encontrada com ID: ' . $id);
        }
        
        if ($locacao['status'] !== 'ativa') {
            return redirect()->to('/locacoes')
                ->with('error', 'Esta locação não está ativa e não pode ser cancelada.');
        }
        
        // Busca informações adicionais
        $cliente = $this->clienteModel->find($locacao['cliente_id']);
        $veiculo = $this->veiculoModel->find($locacao['veiculo_id']);
        
        $data = [
            'titulo' => 'Confirmar Cancelamento',
            'locacao' => $locacao,
            'cliente' => $cliente,
            'veiculo' => $veiculo
        ];
        
        return view('locacoes/cancelar', $data);
    }
    
    /**
     * Processa o cancelamento de uma locação
     */
    public function cancelar($id = null)
    {
        if ($id === null) {
            return redirect()->to('/locacoes')
                ->with('error', 'ID da locação não fornecido.');
        }
        
        $locacao = $this->locacaoModel->find($id);
        
        if ($locacao === null) {
            throw new PageNotFoundException('Locação não encontrada com ID: ' . $id);
        }
        
        if ($locacao['status'] !== 'ativa') {
            return redirect()->to('/locacoes')
                ->with('error', 'Esta locação não está ativa e não pode ser cancelada.');
        }
        
        // Atualiza o status da locação para cancelada
        if ($this->locacaoModel->update($id, ['status' => 'cancelada'])) {
            // Atualiza o status do veículo para disponível
            $this->veiculoModel->atualizarStatus($locacao['veiculo_id'], 'disponivel');
            
            return redirect()->to('/locacoes')
                ->with('mensagem', 'Locação cancelada com sucesso.');
        } else {
            return redirect()->to('/locacoes')
                ->with('error', 'Não foi possível cancelar a locação.');
        }
    }
    
    /**
     * Busca o valor da diária de um veículo via AJAX
     */
    public function getValorDiaria()
    {
        if ($this->request->isAJAX()) {
            $veiculoId = $this->request->getGet('veiculo_id');
            
            $veiculo = $this->veiculoModel->find($veiculoId);
            if (!$veiculo) {
                return $this->response->setJSON(['success' => false, 'message' => 'Veículo não encontrado']);
            }
            
            $categoria = $this->categoriaModel->find($veiculo['categoria_id']);
            if (!$categoria) {
                return $this->response->setJSON(['success' => false, 'message' => 'Categoria não encontrada']);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'valor_diaria' => $categoria['valor_diaria'],
                'categoria' => $categoria['nome']
            ]);
        }
        
        return $this->response->setStatusCode(404);
    }
    
    /**
     * Calcula o valor total de uma locação via AJAX
     */
    public function calcularValor()
    {
        if ($this->request->isAJAX()) {
            $valorDiaria = $this->request->getGet('valor_diaria');
            $dataRetirada = $this->request->getGet('data_retirada');
            $dataDevolucao = $this->request->getGet('data_devolucao');
            
            $valorTotal = $this->locacaoModel->calcularValorTotal($valorDiaria, $dataRetirada, $dataDevolucao);
            
            return $this->response->setJSON([
                'success' => true,
                'valor_total' => $valorTotal
            ]);
        }
        
        return $this->response->setStatusCode(404);
    }
}
