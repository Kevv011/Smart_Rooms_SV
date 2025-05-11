<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.css">
    <!-- Link de archivo de estilos navbar.css -->
    <link href="/<?= $_SESSION['rootFolder'] ?>/public/css/navbar.css" rel="stylesheet">
    <!-- Estilos google fonts-->
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap");
    </style>
</head>

<body>
    <div class="navbars">

        <!-- NAVBAR PRINCIPAL -->
        <nav class="main-navbar navbar navbar-expand bg-white p-3 border-bottom border-black">
            <div class="container-fluid justify-content-between">

                <a href="/<?= $_SESSION['rootFolder'] ?>/Home/index/" class="logo-title d-flex justify-content-center align-items-center gap-2">
                    <img src="/<?= $_SESSION['rootFolder'] ?>/public/img/long-logotype.png" class="d-none d-md-inline-block" alt="smart rooms sv" width="220">
                    <img src="/<?= $_SESSION['rootFolder'] ?>/public/img/short-logotype.png" class="d-inline-block d-md-none" alt="smart rooms sv" height="50">
                </a>

                <!--LISTA NAV-->
                <ul class="navbar-nav">
                    <li>
                        <!--DROPDOWN USER-->
                        <div class="btn-group dropstart">


                            <button class="btn dropdown-toggle border rounded-pill d-flex justify-content-center align-items-center gap-2 p-2 px-3 text-black" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>

                                <div class="d-flex justify-content-center align-items-center text-center">
                                    <?php
                                    if (!isset($_SESSION['id_user'])) {
                                        echo '<i class="fa-solid fa-user fs-5"></i>';
                                    } else {
                                        echo '<div class="d-flex align-items-center">';

                                        echo $_SESSION['user_role'] === "administrador"
                                            ? '<i class="fa-solid fa-user-tie fs-5 me-2"></i>'
                                            : '<i class="fa-solid fa-user fs-5 me-2"></i>';
                                        echo '<p class="mb-0 text-capitalize">' . $_SESSION['user_name'] . '</p>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>

                            </button>

                            <ul class="dropdown-menu" style="width: 217px;">
                                <?php if (!isset($_SESSION['id_user'], $_SESSION['user_name'], $_SESSION['user_role'])) { ?>
                                    <li><button type="button" class="btn pe-5" data-bs-toggle="modal" data-bs-target="#register">Registrate</button></li>
                                    <li><button type="button" class="btn pe-4" data-bs-toggle="modal" data-bs-target="#login">Iniciar Sesión</button></li>
                                <?php } else { ?>
                                    <li><button type="button" class="btn pe-4" data-bs-toggle="modal" data-bs-target="#logout">Cerrar Sesión</button></li>
                                    <hr>

                                    <?php if ($_SESSION['user_role'] == 'administrador') { ?>
                                        <li><a href="#" class="btn"><i class="fa-solid fa-user"></i> Usuarios</a></li>
                                        
                                        <li><a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/alojamientos" class="btn"><i class="fa-solid fa-house-user"></i> Alojamientos</a></li>
                                        <li><a href="/<?= $_SESSION['rootFolder'] ?>/Usuario/usuarios" class="btn"><i class="fa-solid fa-user"></i> Empleados</a></li>
                                        <li><a href="#" class="btn"><i class="fa-solid fa-clipboard-list"></i> Reservaciones</a></li>

                                    <?php } else { ?>
                                        <li><a href="#" class="btn"><i class="fa-solid fa-heart text-danger"></i> Favoritos</a></li>
                                        <li><a href="#" class="btn"><i class="fa-solid fa-calendar-days"></i> Mis reservaciones</a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- NAVBAR SECUNDARIO -->
        <nav class="sec-navbar navbar navbar-expand bg-dark p-1">
            <div class="container-fluid justify-content-between">
                <div></div>

                <!--LISTA NAV-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 text-white" href="#">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <?= (!isset($_SESSION['id_user'], $_SESSION['user_name'], $_SESSION['user_role']))
                            ? '<a href="#" data-bs-toggle="modal" data-bs-target="#login" class="nav-link px-2 px-sm-4 text-white">Reservación</a>'
                            : '<a href="/' . $_SESSION['rootFolder'] . '/app/Reservation/reservations" class="nav-link px-2 px-sm-4 text-white">Reservación</a>' ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 px-sm-4 text-white" href="#">Ofertas</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!--Modal que contiene la informacion para el registro-->
    <div class="modal fade" id="register" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative d-flex justify-content-center align-items-center py-2">
                    <p class="text-black fs-3 fw-bold m-0 text-center w-100">Registro</p>
                    <button type="button" class="btn position-absolute end-0 me-3" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php include "app/views/register.php" ?> <!-- Se incluye a register.php -->
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!--Modal que contiene la informacion para el inicio de sesion-->
    <div class="modal fade" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative d-flex justify-content-center align-items-center py-2">
                    <p class="text-black fs-3 fw-bold m-0 text-center w-100">Iniciar Sesión</p>
                    <button type="button" class="btn position-absolute end-0 me-3" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php include "app/views/login.php" ?> <!-- Se incluye a login.php -->
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!--Modal que aparece al cerrar la sesion-->
    <div class="modal fade" id="logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative d-flex justify-content-center align-items-center py-2">
                    <p class="text-black fs-3 fw-bold m-0 text-center w-100">Cerrar Sesión</p>
                    <button type="button" class="btn position-absolute end-0 me-3" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h5>¿Estás seguro de cerrar sesión?</h5>
                    <hr>

                    <div class="text-center">
                        <a href="/<?= $_SESSION['rootFolder'] ?>/Auth/logout" class="btn btn-info text-white">Confirmar</a>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.1/dist/sweetalert2.min.js"></script>
</body>

</html>