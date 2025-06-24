<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'descricao',
        'valor_diaria'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nome'         => 'required|min_length[3]|max_length[50]|is_unique[categorias.nome,id,{id}]',
        'descricao'    => 'permit_empty|max_length[255]',
        'valor_diaria' => 'required|numeric|greater_than[0]',
    ];
    
    protected $validationMessages   = [
        'nome' => [
            'required' => 'O nome da categoria é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos {param} caracteres.',
            'max_length' => 'O nome não pode ter mais de {param} caracteres.',
            'is_unique' => 'Já existe uma categoria com este nome.'
        ],
        'descricao' => [
            'max_length' => 'A descrição não pode ter mais de {param} caracteres.'
        ],
        'valor_diaria' => [
            'required' => 'O valor da diária é obrigatório.',
            'numeric' => 'O valor da diária deve ser um número.',
            'greater_than' => 'O valor da diária deve ser maior que zero.'
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
     * Verifica se uma categoria pode ser excluída
     * (não pode ter veículos associados)
     *
     * @param int $id ID da categoria
     * @return bool
     */
    public function podeExcluir($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('veiculos');
        $builder->where('categoria_id', $id);
        $count = $builder->countAllResults();
        
        return ($count == 0);
    }
    
    /**
     * Retorna todas as categorias em formato de array para uso em dropdowns
     *
     * @return array
     */
    public function getDropdownList()
    {
        $categorias = $this->findAll();
        $lista = [];
        
        foreach ($categorias as $categoria) {
            $lista[$categoria['id']] = $categoria['nome'] . ' (R$ ' . number_format($categoria['valor_diaria'], 2, ',', '.') . ')';
        }
        
        return $lista;
    }
}
