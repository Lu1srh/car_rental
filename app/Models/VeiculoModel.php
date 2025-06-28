<?php

namespace App\Models;

use CodeIgniter\Model;

class VeiculoModel extends Model
{
    protected $table            = 'veiculos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'marca', 
        'modelo', 
        'ano', 
        'placa', 
        'cor', 
        'categoria_id', 
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'marca'        => 'required|min_length[2]|max_length[50]',
        'modelo'       => 'required|min_length[2]|max_length[100]',
        'ano'          => 'required|numeric|exact_length[4]',
        'placa'        => 'required|min_length[7]|max_length[10]|is_unique[veiculos.placa,id,{id}]',
        'cor'          => 'required|min_length[3]|max_length[30]',
        'categoria_id' => 'required|numeric|is_not_unique[categorias.id]',
        'status'       => 'required|in_list[disponivel,locado,manutencao]',
    ];
    
    protected $validationMessages   = [
        'marca' => [
            'required' => 'A marca do veículo é obrigatória.',
            'min_length' => 'A marca deve ter pelo menos {param} caracteres.',
            'max_length' => 'A marca não pode ter mais de {param} caracteres.'
        ],
        'modelo' => [
            'required' => 'O modelo do veículo é obrigatório.',
            'min_length' => 'O modelo deve ter pelo menos {param} caracteres.',
            'max_length' => 'O modelo não pode ter mais de {param} caracteres.'
        ],
        'ano' => [
            'required' => 'O ano do veículo é obrigatório.',
            'numeric' => 'O ano deve conter apenas números.',
            'exact_length' => 'O ano deve ter exatamente {param} dígitos.'
        ],
        'placa' => [
            'required' => 'A placa do veículo é obrigatória.',
            'min_length' => 'A placa deve ter pelo menos {param} caracteres.',
            'max_length' => 'A placa não pode ter mais de {param} caracteres.',
            'is_unique' => 'Esta placa já está cadastrada para outro veículo.'
        ],
        'cor' => [
            'required' => 'A cor do veículo é obrigatória.',
            'min_length' => 'A cor deve ter pelo menos {param} caracteres.',
            'max_length' => 'A cor não pode ter mais de {param} caracteres.'
        ],
        'categoria_id' => [
            'required' => 'A categoria do veículo é obrigatória.',
            'numeric' => 'A categoria deve ser um número.',
            'is_not_unique' => 'A categoria selecionada não existe.'
        ],
        'status' => [
            'required' => 'O status do veículo é obrigatório.',
            'in_list' => 'O status deve ser: disponível, locado ou manutenção.'
        ]
    ];
    
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    /**
     * Busca veículos com filtros
     *
     * @param array $filtros Array com os filtros a serem aplicados
     * @return array
     */
    public function buscarComFiltros($filtros = [])
    {
        $builder = $this->builder();
        $builder->select('veiculos.*, categorias.nome as categoria_nome');
        $builder->join('categorias', 'categorias.id = veiculos.categoria_id');
        
        // Aplicar filtros se existirem
        if (!empty($filtros['marca'])) {
            $builder->like('veiculos.marca', $filtros['marca']);
        }
        
        if (!empty($filtros['modelo'])) {
            $builder->like('veiculos.modelo', $filtros['modelo']);
        }
        
        if (!empty($filtros['ano'])) {
            $builder->where('veiculos.ano', $filtros['ano']);
        }
        
        if (!empty($filtros['cor'])) {
            $builder->like('veiculos.cor', $filtros['cor']);
        }
        
        if (!empty($filtros['categoria_id'])) {
            $builder->where('veiculos.categoria_id', $filtros['categoria_id']);
        }
        
        if (!empty($filtros['status'])) {
            $builder->where('veiculos.status', $filtros['status']);
        }
        
        // Ordenação
        $builder->orderBy('veiculos.marca', 'ASC');
        $builder->orderBy('veiculos.modelo', 'ASC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Busca veículos disponíveis para locação
     *
     * @return array
     */
    public function buscarDisponiveis()
    {
        return $this->where('status', 'disponivel')
                    ->orderBy('marca', 'ASC')
                    ->orderBy('modelo', 'ASC')
                    ->findAll();
    }
    
    /**
     * Atualiza o status de um veículo
     *
     * @param int $id ID do veículo
     * @param string $status Novo status
     * @return bool
     */
    public function atualizarStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}