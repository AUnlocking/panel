<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Geniush's License Manager</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- jQuery Confirm CSS -->
    <link rel="stylesheet" href="css/jquery-confirm.min.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body class="bg-dark text-light">
    <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-key-fill me-2"></i>EasyLicense-Legacy
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="log.php">
                            <i class="bi bi-journal-text me-1"></i>Registros
                        </a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link btn btn-link" id="LicenseGenerate">
                            <i class="bi bi-magic me-1"></i>Generar Licencias
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link btn btn-link" id="LicenseCreate">
                            <i class="bi bi-pencil-square me-1"></i>Crear Licencias
                        </button>
                    </li>
                </ul>
                
                <form class="d-flex" action="index.php" method="post">
                    <div class="input-group">
                        <input class="form-control bg-secondary text-white border-secondary" 
                               id="SearchText" type="search" 
                               placeholder="Buscar..." 
                               aria-label="Buscar" 
                               name="query"
                               required>
                        <button class="btn btn-info" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container-fluid pt-5 mt-4 pb-6">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 mb-4">
                    <i class="bi bi-key me-2"></i>Administrador de Licencias
                </h1>
                
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-striped align-middle">
                        <?php
                        require_once 'config/db.php';
                        require_once 'php/PrintDB.php';

                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
                            $query = trim($_POST['query']);$searchQuery = mysqli_real_escape_string($link, $query);
                            
                            $sql = "SELECT 
                                    id, 
                                    lickey as 'Clave de Licencia', 
                                    hwid as 'HWID', 
                                    owner as 'Propietario', 
                                    active as 'Activa', 
                                    banned as 'Bloqueada', 
                                    created as 'Creada', 
                                    logins as 'Inicios', 
                                    type as 'Producto', 
                                    lastip as 'Última IP' 
                                FROM license 
                                WHERE 
                                    id LIKE '%$searchQuery%' OR 
                                    lickey LIKE '%$searchQuery%' OR 
                                    hwid LIKE '%$searchQuery%' OR 
                                    active LIKE '%$searchQuery%' OR 
                                    banned LIKE '%$searchQuery%' OR 
                                    owner LIKE '%$searchQuery%' OR 
                                    created LIKE '%$searchQuery%' OR 
                                    logins LIKE '%$searchQuery%' OR 
                                    type LIKE '%$searchQuery%' OR 
                                    lastip LIKE '%$searchQuery%' 
                                ORDER BY id";
                            
                            print_db($link, $sql);
                        } else {
                            print_db($link, "SELECT 
                                    id, 
                                    lickey as 'Clave de Licencia', 
                                    hwid as 'HWID', 
                                    owner as 'Propietario', 
                                    active as 'Activa', 
                                    banned as 'Bloqueada', 
                                    created as 'Creada', 
                                    logins as 'Inicios', 
                                    type as 'Producto', 
                                    lastip as 'Última IP' 
                                FROM license 
                                ORDER BY id");
                        }
                        
                        mysqli_close($link);
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Barra de navegación inferior (acciones) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom shadow-lg">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-tools me-2"></i>Acciones
            </span>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#actionsNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="actionsNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-power me-1"></i>Estado
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><button class="dropdown-item jsbutton" id="keyenable">
                                <i class="bi bi-check-circle me-2"></i>Activar
                            </button></li>
                            <li><button class="dropdown-item jsbutton" id="keydisable"><i class="bi bi-x-circle me-2"></i>Desactivar
                            </button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item jsbutton" id="keyban">
                                <i class="bi bi-slash-circle me-2"></i>Bloquear
                            </button></li>
                            <li><button class="dropdown-item jsbutton" id="keyunban">
                                <i class="bi bi-unlock me-2"></i>Desbloquear
                            </button></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-key me-1"></i>Licencia
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><button class="dropdown-item jsbutton" id="keyset">
                                <i class="bi bi-pencil me-2"></i>Cambiar Clave
                            </button></li>
                            <li><button class="dropdown-item jsbutton" id="keydelete">
                                <i class="bi bi-trash me-2"></i>Eliminar
                            </button></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-cpu me-1"></i>HWID
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><button class="dropdown-item jsbutton" id="hwidreset">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reiniciar
                            </button></li>
                            <li><button class="dropdown-item jsbutton" id="hwidset">
                                <i class="bi bi-pencil me-2"></i>Establecer
                            </button></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person me-1"></i>Propietario
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><button class="dropdown-item jsbutton" id="ownerreset">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reiniciar
                            </button></li>
                            <li><button class="dropdown-item jsbutton" id="ownerset">
                                <i class="bi bi-pencil me-2"></i>Establecer
                            </button></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-box me-1"></i>Producto
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><button class="dropdown-item jsbutton" id="typereset">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reiniciar
                            </button></li>
                            <li><button class="dropdown-item jsbutton" id="typeset">
                                <i class="bi bi-pencil me-2"></i>Establecer</button></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <button class="nav-link jsbutton" id="loginsreset">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reiniciar Inicios
                        </button>
                    </li>
                    
                    <li class="nav-item">
                        <button class="nav-link jsbutton" id="ipreset">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reiniciar IP
                        </button>
                    </li>
                </ul>
                
                <form class="d-flex align-items-center">
                    <div class="form-check form-switch me-3">
                        <input class="form-check-input" type="checkbox" id="checkAll" role="switch">
                        <label class="form-check-label" for="checkAll">Seleccionar Todo</label>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery Confirm -->
    <script src="js/jquery-confirm.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script src="js/buttons.js"></script>
</body>
</html>