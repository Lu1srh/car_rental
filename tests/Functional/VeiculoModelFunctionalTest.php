<?php

namespace Tests\Functional;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\VeiculoModel;

class VeiculoModelFunctionalTest extends CIUnitTestCase
{
    protected $refresh = true;
    protected $seed = 'TestSeeder';

    public function testBuscarDisponiveisRetornaSomenteDisponiveis()
    {
        $model = new VeiculoModel();

        $veiculos = $model->buscarDisponiveis();

        $this->assertNotEmpty(
            $veiculos,
            "Nenhum veículo disponível foi retornado."
        );

        foreach ($veiculos as $veiculo) {
            $this->assertEquals(
                'disponivel',
                $veiculo['status'],
                "Veículo ID {$veiculo['id']} não está disponível."
            );
        }
    }
}
