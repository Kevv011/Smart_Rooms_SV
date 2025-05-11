<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalles del Alojamiento</title>
    </head>

    <body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->
        
        <main class="container mb-3" style="margin-top: 150px;">

            <h2 class="mb-4 text-center text-capitalize"> <?= htmlspecialchars($usuario['nombre']); ?> <?= htmlspecialchars($usuario['apellido']); ?></h2>

            <!-- Imagen principal -->
            <div class="text-center mb-4">
                <i class="fa-solid fa-user-tie" style='font-size:100px'></i>
            </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                         <div class="card-body p-0">
                             <p class="card-text fst-italic fs-5 pb-1"><?= htmlspecialchars($usuario['rol']); ?></p>
                                     <ul class="list-unstyled mt-3">
                                     <li class="mb-2"><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']); ?></li>
                                     <li class="mb-2"><strong>Telefono:</strong> <?= htmlspecialchars($usuario['telefono']); ?></li>
                                     <li class="mb-2"><strong>Estado:</strong> <?= htmlspecialchars($usuario['estado']); ?> </li>
                                     <li class="mb-2"><strong>Fecha de registro:</strong> <?= ($usuario['usuario_registro']);?></li>
                                     </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow p-4 bg-white">
                            <h4 class="mb-3">
                                <strong><strong>ID de empleado:</strong> <?= htmlspecialchars($usuario['id_empleado']); ?></strong> <!-- id_empleado de empleado -->
                            </h4>

                             <div class="border rounded">
                                 <div class="row g-0">
                                     <!-- Huéspedes -->
                                        <div class="col-12 border-top p-3">
                                        <ul class="list-unstyled mt-3">
                                            <li class="mb-2"><strong>Cargo:</strong> <?= htmlspecialchars($usuario['cargo']); ?></li>
                                            <li class="mb-2"><strong>Actualizado:</strong> <?= htmlspecialchars($usuario['actualizado_en']); ?></li>
                                        </ul>
                                        </div>
                                </div>
                             </div>

                        <!--Botones para el ADMINISTRADOR-->
                        <?php if ($_SESSION['user_role'] === "administrador") { ?>
                            
                                <button type="button" id="editButton" class="btn w-100 mt-3 text-white mb-2" style="background: linear-gradient(to right,rgb(56, 109, 255),rgb(0, 218, 247)); border: none;">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Editar
                                </button>
                                <button type="button" class="btn btn-danger text-white mt-2" data-bs-toggle="modal" data-bs-target="#modalDelete"> <i class="fa-solid fa-trash me-1"></i>Eliminar</button>
                            <?php 
                        }  ?>

                        </div>
                    </div>
                </div>
         </main>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
