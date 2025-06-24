<?php

namespace App\Models;

use CodeIgniter\Model;

class LocacaoModel extends Model
{
    protected $table            = 'locacoes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cliente_id',
        'veiculo_id',
        'data_retirada',
        'data_devolucao_prevista',
        'data_devolucao_efetiva',
        'valor_diaria',
        'valor_total',
        'multa_atraso',
        'observacoes_devolucao',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'cliente_id'              => 'required|numeric|is_not_unique[clientes.id]',
        'veiculo_id'              => 'required|numeric|is_not_unique[veiculos.id]',
        'data_retirada'           => 'required|valid_date',
        'data_devolucao_prevista' => 'required|valid_date',
        'data_devolucao_efetiva'  => 'permit_empty|valid_date',
        'valor_diaria'            => 'required|numeric|greater_than[0]',
        'valor_total'             => 'required|numeric|greater_than[0]',
        'multa_atraso'            => 'permit_empty|numeric|greater_than_equal_to[0]',
        'observacoes_devolucao'   => 'permit_empty',
        'status'                  => 'required|in_list[ativa,finalizada,cancelada]'
    ];
    
    protected $validationMessages   = [
        'cliente_id' => [
            'required' => 'O cliente é obrigatório.',
            'numeric' => 'O cliente deve ser um número.',
            'is_not_unique' => 'O cliente selecionado não existe.'
        ],
        'veiculo_id' => [
            'required' => 'O veículo é obrigatório.',
            'numeric' => 'O veículo deve ser um número.',
            'is_not_unique' => 'O veículo selecionado não existe.'
        ],
        'data_retirada' => [
            'required' => 'A data de retirada é obrigatória.',
            'valid_date' => 'A data de retirada deve ser uma data válida.'
        ],
        'data_devolucao_prevista' => [
            'required' => 'A data de devolução prevista é obrigatória.',
            'valid_date' => 'A data de devolução prevista deve ser uma data válida.'
        ],
        'data_devolucao_efetiva' => [
            'valid_date' => 'A data de devolução efetiva deve ser uma data válida.'
        ],
        'valor_diaria' => [
            'required' => 'O valor da diária é obrigatório.',
            'numeric' => 'O valor da diária deve ser um número.',
            'greater_than' => 'O valor da diária deve ser maior que zero.'
        ],
        'valor_total' => [
            'required' => 'O valor total é obrigatório.',
            'numeric' => 'O valor total deve ser um número.',
            'greater_than' => 'O valor total deve ser maior que zero.'
        ],
        'multa_atraso' => [
            'numeric' => 'O valor da multa deve ser um número.',
            'greater_than_equal_to' => 'O valor da multa não pode ser negativo.'
        ],
        'status' => [
            'required' => 'O status da locação é obrigatório.',
            'in_list' => 'O status deve ser: ativa, finalizada ou cancelada.'
        ]
    ];
    
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['verificarDisponibilidadeVeiculo'];
    protected $afterInsert    = ['atualizarStatusVeiculo'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = ['processarDevolucao'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    /**
     * Verifica se o veículo está disponível antes de registrar a locação
     *
     * @param array $data
     * @return array
     */
    protected function verificarDisponibilidadeVeiculo(array $data)
    {
        if (isset($data['data']['veiculo_id'])) {
            $veiculoModel = new VeiculoModel();
            $veiculo = $veiculoModel->find($data['data']['veiculo_id']);
            
            if ($veiculo && $veiculo['status'] !== 'disponivel') {
                $this->validationMessages['veiculo_id']['disponivel'] = 'O veículo selecionado não está disponível para locação.';
                $this->validation->setError('veiculo_id', 'O veículo selecionado não está disponível para locação.');
            }
        }
        
        return $data;
    }
    
    /**
     * Atualiza o status do veículo para 'locado' após registrar a locação
     *
     * @param array $data
     * @return array
     */
    protected function atualizarStatusVeiculo(array $data)
    {
        if (isset($data['data']['veiculo_id']) && isset($data['result']) && $data['result'] === true) {
            $veiculoModel = new VeiculoModel();
            $veiculoModel->atualizarStatus($data['data']['veiculo_id'], 'locado');
        }
        
        return $data;
    }
    
    /**
     * Processa a devolução do veículo quando a locação é finalizada
     *
     * @param array $data
     * @return array
     */
    protected function processarDevolucao(array $data)
    {
        // Verifica se é uma atualização de status para finalizada
        if (isset($data['data']['status']) && $data['data']['status'] === 'finalizada' && isset($data['id'])) {
            // Busca a locação atual
            $locacao = $this->find($data['id']);
            
            if ($locacao && isset($locacao['veiculo_id'])) {
                // Atualiza o status do veículo para disponível
                $veiculoModel = new VeiculoModel();
                $veiculoModel->atualizarStatus($locacao['veiculo_id'], 'disponivel');
            }
        }
        
        return $data;
    }
    
    /**
     * Calcula o valor total da locação com base na diária e período
     *
     * @param float $valorDiaria Valor da diária
     * @param string $dataRetirada Data de retirada (Y-m-d H:i:s)
     * @param string $dataDevolucaoPrevista Data de devolução prevista (Y-m-d H:i:s)
     * @return float
     */
    public function calcularValorTotal($valorDiaria, $dataRetirada, $dataDevolucaoPrevista)
    {
        $retirada = new \DateTime($dataRetirada);
        $devolucao = new \DateTime($dataDevolucaoPrevista);
        
        // Calcula a diferença em dias
        $diff = $retirada->diff($devolucao);
        $dias = $diff->days;
        
        // Se for no mesmo dia, considera como 1 dia
        if ($dias === 0) {
            $dias = 1;
        }
        
        return $valorDiaria * $dias;
    }
    
    /**
     * Calcula o valor da multa por atraso na devolução
     *
     * @param float $valorDiaria Valor da diária
     * @param string $dataDevolucaoPrevista Data de devolução prevista (Y-m-d H:i:s)
     * @param string $dataDevolucaoEfetiva Data de devolução efetiva (Y-m-d H:i:s)
     * @return float
     */
    public function calcularMultaAtraso($valorDiaria, $dataDevolucaoPrevista, $dataDevolucaoEfetiva)
    {
        $prevista = new \DateTime($dataDevolucaoPrevista);
        $efetiva = new \DateTime($dataDevolucaoEfetiva);
        
        // Se devolveu antes ou no prazo, não há multa
        if ($efetiva <= $prevista) {
            return 0;
        }
        
        // Calcula a diferença em dias
        $diff = $prevista->diff($efetiva);
        $diasAtraso = $diff->days;
        
        // Multa de 10% por dia de atraso sobre o valor da diária
        $multaPorDia = $valorDiaria * 0.1;
        
        return $multaPorDia * $diasAtraso;
    }
    
    /**
     * Busca locações com filtros
     *
     * @param array $filtros Array com os filtros a serem aplicados
     * @return array
     */
    public function buscarComFiltros($filtros = [])
    {
        $builder = $this->builder();
        $builder->select('locacoes.*, clientes.nome as cliente_nome, veiculos.marca, veiculos.modelo, veiculos.placa');
        $builder->join('clientes', 'clientes.id = locacoes.cliente_id');
        $builder->join('veiculos', 'veiculos.id = locacoes.veiculo_id');
        
        // Aplicar filtros se existirem
        if (!empty($filtros['cliente_id'])) {
            $builder->where('locacoes.cliente_id', $filtros['cliente_id']);
        }
        
        if (!empty($filtros['veiculo_id'])) {
            $builder->where('locacoes.veiculo_id', $filtros['veiculo_id']);
        }
        
        if (!empty($filtros['status'])) {
            $builder->where('locacoes.status', $filtros['status']);
        }
        
        if (!empty($filtros['data_inicio']) && !empty($filtros['data_fim'])) {
            $builder->where('locacoes.data_retirada >=', $filtros['data_inicio'] . ' 00:00:00');
            $builder->where('locacoes.data_retirada <=', $filtros['data_fim'] . ' 23:59:59');
        }
        
        // Ordenação
        $builder->orderBy('locacoes.data_retirada', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Verifica se um veículo pode ser excluído (não tem locações)
     *
     * @param int $veiculoId ID do veículo
     * @return bool
     */
    public function veiculoPossuiLocacoes($veiculoId)
    {
        return $this->where('veiculo_id', $veiculoId)->countAllResults() > 0;
    }
    
    /**
     * Verifica se um cliente pode ser excluído (não tem locações)
     *
     * @param int $clienteId ID do cliente
     * @return bool
     */
    public function clientePossuiLocacoes($clienteId)
    {
        return $this->where('cliente_id', $clienteId)->countAllResults() > 0;
    }
}
