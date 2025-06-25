<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\VeiculoModel;

final class VeiculoModelTest extends CIUnitTestCase
{
    protected VeiculoModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new VeiculoModel();
    }

    public function testBuscarDisponiveisRetornaArray(): void
    {
        $veiculos = $this->model->buscarDisponiveis();

        $this->assertIsArray($veiculos, 'Deve retornar um array');
        $this->assertNotEmpty($veiculos, 'Deve retornar ao menos um veículo disponível');

        // Verificar se todos os veículos têm status 'disponivel'
        foreach ($veiculos as $veiculo) {
            $this->assertEquals('disponivel', $veiculo['status'], 'Veículo deve estar disponível');
        }
    }

    public function testBuscarComFiltrosMarca(): void
    {
        $filtros = ['marca' => 'Toyota'];
        $result = $this->model->buscarComFiltros($filtros);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        foreach ($result as $veiculo) {
            $this->assertStringContainsStringIgnoringCase('Toyota', $veiculo['marca']);
        }
    }

    public function testAtualizarStatus(): void
    {
        // Pega o primeiro veículo para atualizar
        $veiculos = $this->model->findAll();
        $this->assertNotEmpty($veiculos);

        $veiculoId = $veiculos[0]['id'];
        $novoStatus = 'manutencao';

        $updated = $this->model->atualizarStatus($veiculoId, $novoStatus);
        $this->assertTrue($updated);

        $veiculoAtualizado = $this->model->find($veiculoId);
        $this->assertEquals($novoStatus, $veiculoAtualizado['status']);
    }
}
