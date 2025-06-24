<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'cpf',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'email',
        'ativo'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nome'        => 'required|min_length[3]|max_length[100]',
        'cpf' => 'required|min_length[11]|max_length[14]|cpfUnico[{id}]',
        'logradouro'  => 'required|min_length[3]|max_length[100]',
        'numero'      => 'required|max_length[10]',
        'complemento' => 'permit_empty|max_length[50]',
        'bairro'      => 'required|min_length[2]|max_length[50]',
        'cidade'      => 'required|min_length[2]|max_length[50]',
        'estado'      => 'required|exact_length[2]',
        'cep'         => 'required|min_length[8]|max_length[9]',
        'telefone'    => 'required|min_length[10]|max_length[15]',
        'email'       => 'required|valid_email|max_length[100]',
        'ativo'       => 'permit_empty'
    ];



    public function validarCpfUnico(string $cpf, string $id = null): bool
{
    $cpf = preg_replace('/\D/', '', $cpf); // Remove caracteres não numéricos

    $builder = $this->builder();
    $builder->where('cpf', $cpf);

    if ($id !== null) {
        $builder->where('id !=', $id);
    }

    $existe = $builder->countAllResults() > 0;

    return !$existe;
}

    
    protected $validationMessages   = [
        'nome' => [
            'required' => 'O nome do cliente é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos {param} caracteres.',
            'max_length' => 'O nome não pode ter mais de {param} caracteres.'
        ],
        'cpf' => [
            'required' => 'O CPF do cliente é obrigatório.',
            'min_length' => 'O CPF deve ter pelo menos {param} caracteres.',
            'max_length' => 'O CPF não pode ter mais de {param} caracteres.',
            'is_unique' => 'Este CPF já está cadastrado para outro cliente.'
        ],
        'logradouro' => [
            'required' => 'O logradouro é obrigatório.',
            'min_length' => 'O logradouro deve ter pelo menos {param} caracteres.',
            'max_length' => 'O logradouro não pode ter mais de {param} caracteres.'
        ],
        'numero' => [
            'required' => 'O número é obrigatório.',
            'max_length' => 'O número não pode ter mais de {param} caracteres.'
        ],
        'complemento' => [
            'max_length' => 'O complemento não pode ter mais de {param} caracteres.'
        ],
        'bairro' => [
            'required' => 'O bairro é obrigatório.',
            'min_length' => 'O bairro deve ter pelo menos {param} caracteres.',
            'max_length' => 'O bairro não pode ter mais de {param} caracteres.'
        ],
        'cidade' => [
            'required' => 'A cidade é obrigatória.',
            'min_length' => 'A cidade deve ter pelo menos {param} caracteres.',
            'max_length' => 'A cidade não pode ter mais de {param} caracteres.'
        ],
        'estado' => [
            'required' => 'O estado é obrigatório.',
            'exact_length' => 'O estado deve ter exatamente {param} caracteres (UF).'
        ],
        'cep' => [
            'required' => 'O CEP é obrigatório.',
            'min_length' => 'O CEP deve ter pelo menos {param} caracteres.',
            'max_length' => 'O CEP não pode ter mais de {param} caracteres.'
        ],
        'telefone' => [
            'required' => 'O telefone é obrigatório.',
            'min_length' => 'O telefone deve ter pelo menos {param} caracteres.',
            'max_length' => 'O telefone não pode ter mais de {param} caracteres.'
        ],
        'email' => [
            'required' => 'O email é obrigatório.',
            'valid_email' => 'Por favor, informe um endereço de email válido.',
            'max_length' => 'O email não pode ter mais de {param} caracteres.'
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
     * Busca clientes com filtros
     *
     * @param array $filtros Array com os filtros a serem aplicados
     * @return array
     */
    public function buscarComFiltros($filtros = [])
    {
        $builder = $this->builder();
        
        // Aplicar filtros se existirem
        if (!empty($filtros['nome'])) {
            $builder->like('nome', $filtros['nome']);
        }
        
        if (!empty($filtros['cpf'])) {
            $builder->like('cpf', $filtros['cpf']);
        }
        
        if (!empty($filtros['email'])) {
            $builder->like('email', $filtros['email']);
        }
        
        if (!empty($filtros['cidade'])) {
            $builder->like('cidade', $filtros['cidade']);
        }
        
        if (!empty($filtros['estado'])) {
            $builder->where('estado', $filtros['estado']);
        }
        
        if (isset($filtros['ativo']) && $filtros['ativo'] !== '') {
            $builder->where('ativo', $filtros['ativo']);
        }
        
        // Ordenação
        $builder->orderBy('nome', 'ASC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Busca o histórico de locações de um cliente
     *
     * @param int $clienteId ID do cliente
     * @return array
     */
    public function buscarHistoricoLocacoes($clienteId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('locacoes');
        $builder->select('locacoes.*, veiculos.marca, veiculos.modelo, veiculos.placa');
        $builder->join('veiculos', 'veiculos.id = locacoes.veiculo_id');
        $builder->where('locacoes.cliente_id', $clienteId);
        $builder->orderBy('locacoes.data_retirada', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Formata o endereço completo do cliente
     *
     * @param array $cliente Dados do cliente
     * @return string
     */
    public function formatarEndereco($cliente)
    {
        $endereco = $cliente['logradouro'] . ', ' . $cliente['numero'];
        
        if (!empty($cliente['complemento'])) {
            $endereco .= ' - ' . $cliente['complemento'];
        }
        
        $endereco .= ' - ' . $cliente['bairro'] . ', ' . $cliente['cidade'] . '/' . $cliente['estado'] . ' - CEP: ' . $cliente['cep'];
        
        return $endereco;
    }
}


