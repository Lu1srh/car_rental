<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora de Carros - Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 15px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 1rem 0;
            margin-top: auto;
        }
        
        /* Responsividade para dispositivos móveis */
        @media (max-width: 576px) {
            .login-container {
                padding: 10px;
            }
            
            .card-header h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <main>
        <?= $this->renderSection('conteudo') ?>
    </main>

    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (necessário para alguns componentes) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-fecha alertas após 5 segundos
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
