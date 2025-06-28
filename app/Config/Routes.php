<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rotas de autenticação
$routes->get('/', 'Auth::index');       
$routes->get('login', 'Auth::index');   
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout'); 
$routes->get('dashboard/novoUsuario', 'Dashboard::novoUsuario');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

// Dashboard (protegido com filtro)
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard/usuarios', 'Dashboard::usuarios');
$routes->get('/dashboard/perfil', 'Dashboard::perfil');

// Rotas para veículos
$routes->get('veiculos', 'Veiculos::index');
$routes->get('veiculos/novo', 'Veiculos::novo');  
$routes->post('veiculos/criar', 'Veiculos::criar');
$routes->get('veiculos/editar/(:num)', 'Veiculos::editar/$1');  
$routes->post('veiculos/atualizar/(:num)', 'Veiculos::atualizar/$1');  
$routes->get('veiculos/detalhes/(:num)', 'Veiculos::detalhes/$1');
$routes->post('veiculos/atualizarStatus/(:num)', 'Veiculos::atualizarStatus/$1');

// Rotas para clientes
$routes->get('/clientes', 'Clientes::index');
$routes->get('/clientes/novo', 'Clientes::novo');
$routes->post('/clientes/criar', 'Clientes::criar');
$routes->get('/clientes/editar/(:num)', 'Clientes::editar/$1');
$routes->post('/clientes/atualizar/(:num)', 'Clientes::atualizar/$1');
$routes->get('/clientes/detalhes/(:num)', 'Clientes::detalhes/$1');
$routes->get('/clientes/confirmarExclusao/(:num)', 'Clientes::confirmarExclusao/$1');
$routes->post('/clientes/excluir/(:num)', 'Clientes::excluir/$1');
$routes->get('/clientes/editar/(:num)', 'Clientes::editar/$1');  
$routes->post('/clientes/atualizar/(:num)', 'Clientes::atualizar/$1'); 
$routes->get('clientes/desativar/(:num)', 'Clientes::desativar/$1');
$routes->post('dashboard/criarUsuario', 'Dashboard::criarUsuario');

// Rotas para locações
$routes->get('locacoes', 'Locacoes::index');
$routes->get('locacoes/nova', 'Locacoes::nova');
$routes->post('locacoes/criar', 'Locacoes::criar');
$routes->get('locacoes/detalhes/(:num)', 'Locacoes::detalhes/$1');
$routes->get('locacoes/devolucao/(:num)', 'Locacoes::devolucao/$1');
$routes->post('locacoes/processarDevolucao/(:num)', 'Locacoes::processarDevolucao/$1');
$routes->get('locacoes/confirmarCancelamento/(:num)', 'Locacoes::confirmarCancelamento/$1');
$routes->post('locacoes/cancelar/(:num)', 'Locacoes::cancelar/$1');

// Rotas AJAX para valores
$routes->get('locacoes/getValorDiaria', 'Locacoes::getValorDiaria');
$routes->get('locacoes/calcularValor', 'Locacoes::calcularValor');
$routes->post('locacoes/processarDevolucao/(:num)', 'Locacoes::processarDevolucao/$1');










