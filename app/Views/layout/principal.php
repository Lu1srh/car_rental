<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora de Carros - <?= $this->renderSection('titulo') ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 56px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        .sidebar {
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            z-index: 100;
            background-color: #f8f9fa;
        }
        
        @media (max-width: 767.98px) {
            .sidebar {
                top: 5rem;
            }
        }
        
        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        .nav-link {
            font-weight: 500;
            color: #333;
        }
        
        .nav-link.active {
            color: #007bff;
        }
        
        .nav-link:hover {
            color: #0056b3;
        }
        
        .nav-link .feather {
            margin-right: 4px;
            color: #727272;
        }
        
        .nav-link.active .feather {
            color: inherit;
        }
        
        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 1rem 0;
            margin-top: auto;
        }
        
        /* Responsividade para dispositivos móveis */
        @media (max-width: 767.98px) {
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.75rem;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            .card-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>">Locadora de Carros</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard') ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('veiculos') ?>">
                            <i class="fas fa-car"></i> Veículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('clientes') ?>">
                            <i class="fas fa-users"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('locacoes') ?>">
                            <i class="fas fa-key"></i> Locações
                        </a>
                    </li>
                    <?php if (session()->get('nivel_acesso') === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard/usuarios') ?>">
                            <i class="fas fa-user-shield"></i> Usuários
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> <?= session()->get('nome') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= site_url('dashboard/perfil') ?>">Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <?= $this->renderSection('conteudo') ?>
    </main>

    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (necessário para alguns componentes) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script>
        // Ativa o item de menu atual com base na URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href.replace('<?= site_url() ?>', ''))) {
                    link.classList.add('active');
                }
            });
            
            // Inicializa tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Auto-fecha alertas após 5 segundos
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
