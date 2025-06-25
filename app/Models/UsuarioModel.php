<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $DBgroup = 'default';
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nome', 'email', 'senha', 'nivel_acesso', 'ativo'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nome' => 'required',
        'email' => 'required|is_unique[usuarios.id,{id}]',
        'senha' => 'required',
        'nivel_acesso' => 'required',
        'ativo' => 'permit_empty'
    ];

    public function verificarCredenciais($email, $senha)
{
    $usuario = $this->where('email', $email)
                    ->where('senha', $senha) 
                    ->first();

    return $usuario;
}

public function buscarComFiltros(array $filtros = [])
{
    $builder = $this->builder();

    if (!empty($filtros['nome'])) {
        $builder->like('nome', $filtros['nome']);
    }

    if (!empty($filtros['email'])) {
        $builder->like('email', $filtros['email']);
    }

    if (!empty($filtros['nivel_acesso'])) {
        $builder->where('nivel_acesso', $filtros['nivel_acesso']);
    }

    if (isset($filtros['ativo']) && $filtros['ativo'] !== '') {
        $builder->where('ativo', $filtros['ativo']);
    }

    return $builder->get()->getResultArray();
}


}
