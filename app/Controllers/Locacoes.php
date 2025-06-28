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

    public function criar()
    {
        $dados = $this->request->getPost();
        // Para debug - depois pode retirar
        log_message('debug', 'Dados recebidos na criação: ' . print_r($dados, true));

        if (empty($dados['veiculo_id'])) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Veículo não informado.']);
        }

        // Busca veículo
        $veiculo = $this->veiculoModel->find($dados['veiculo_id']);
        if (!$veiculo) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Veículo não encontrado.']);
        }

        // Busca categoria pelo veículo
        $categoria = $this->categoriaModel->find($veiculo['categoria_id']);
        if (!$categoria) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Categoria do veículo não encontrada.']);
        }

        // Define o valor da diária baseado na categoria
        $dados['valor_diaria'] = $categoria['valor_diaria'];

        // Valida datas: devolução prevista deve ser maior ou igual à retirada
        $dataRetirada = strtotime($dados['data_retirada']);
        $dataDevolucaoPrevista = strtotime($dados['data_devolucao_prevista']);
        if ($dataDevolucaoPrevista < $dataRetirada) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Data de devolução prevista deve ser igual ou posterior à data de retirada.']);
        }

        // Calcula valor total da locação
        $dados['valor_total'] = $this->locacaoModel->calcularValorTotal(
            $dados['valor_diaria'],
            $dados['data_retirada'],
            $dados['data_devolucao_prevista']
        );

        $dados['status'] = 'ativa';

        if ($this->locacaoModel->insert($dados)) {
            return redirect()->to('locacoes')
                             ->with('success', 'Locação cadastrada com sucesso.');
        } else {
            return redirect()->back()->withInput()
                             ->with('errors', $this->locacaoModel->errors());
        }
    }

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
        
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/locacoes')
                ->with('error', 'Método inválido para processar devolução.');
        }
        
        $dataDevolucaoEfetiva = $this->request->getPost('data_devolucao_efetiva');
        $observacoes = $this->request->getPost('observacoes_devolucao');

        // Calcula multa por atraso
        $multaAtraso = $this->locacaoModel->calcularMultaAtraso(
            $locacao['valor_diaria'],
            $locacao['data_devolucao_prevista'],
            $dataDevolucaoEfetiva
        );

        $dadosAtualizacao = [
            'data_devolucao_efetiva' => $dataDevolucaoEfetiva,
            'observacoes_devolucao' => $observacoes,
            'multa_atraso' => $multaAtraso,
            'status' => 'finalizada'
        ];

        if ($this->locacaoModel->update($id, $dadosAtualizacao)) {
            return redirect()->to('/locacoes')
                ->with('success', 'Devolução registrada com sucesso.');
        } else {
            return redirect()->back()
                ->with('errors', $this->locacaoModel->errors())
                ->withInput();
        }
    }

    // Restante dos métodos do controller sem alterações
    
    public function detalhes($id = null)
    {
        $locacao = $this->locacaoModel->find($id);
        
        if ($locacao === null) {
            throw new PageNotFoundException('Locação não encontrada com ID: ' . $id);
        }
        
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

   public function getValorDiaria()
{
    $veiculoId = $this->request->getGet('veiculo_id');

    if (!$veiculoId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'ID do veículo não fornecido.'
        ]);
    }

    $veiculoModel = new \App\Models\VeiculoModel();
    $categoriaModel = new \App\Models\CategoriaModel();

    $veiculo = $veiculoModel->find($veiculoId);

    if (!$veiculo) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Veículo não encontrado.'
        ]);
    }

    $categoria = $categoriaModel->find($veiculo['categoria_id']);

    if (!$categoria) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Categoria do veículo não encontrada.'
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'categoria' => [
            'nome' => $categoria['nome'],
            'valor_diaria' => $categoria['valor_diaria']
        ]
    ]);
}

}
