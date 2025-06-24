<?php namespace App\Validation;

use App\Models\ClienteModel;



class ClienteRules
{
    public function cpfUnico(string $cpf, string $id = null): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf); // Remove caracteres não numéricos

        $clienteModel = new ClienteModel();

        $query = $clienteModel->where('cpf', $cpf);

        if ($id !== null && is_numeric($id)) {
            $query = $query->where('id !=', $id);
        }

        return ($query->countAllResults() === 0);
    }

    
}
