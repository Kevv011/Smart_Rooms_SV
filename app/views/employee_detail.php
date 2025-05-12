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

         <section id="editForm" class="mt-3" style="display: none;">

            <hr>

            <form action="/<?= $_SESSION['rootFolder'] ?>/Usuario/update" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">

                <!-- id -->
                <input type="text" name="id" value="<?= htmlspecialchars($usuario['id_usuario']); ?>" hidden>

                <!-- Nombre -->
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre </label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
                </div>

                <!-- Apellido -->
                <div class="col-md-6">
                    <label for="descripcion" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($usuario['apellido']); ?>" required>
                </div>

                <!-- Correo -->
                <div class="col-8">
                    <label for="direccion" class="form-label">Correo</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($usuario['correo']); ?>" required>
                </div>

                <!-- Rol -->
                <div class="col-md-4">
                    <label for="departamento" class="form-label">Rol:</label>
                    <select class="form-select" id="departamento" name="departamento" required>
                        <option value="<?= htmlspecialchars($usuario['rol']); ?>" selected><?= htmlspecialchars($usuario['rol']); ?></option>
                        <option value="ahuachapan">administrador</option>
                        <option value="santa ana">anfitrion</option>
                        <option value="sonsonate">empleado</option>
                    </select>
                </div>

                <div class="row my-4">

                    <!-- Cargo -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Cargo </label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['cargo']); ?>" required>
                    </div>
                </div>

                <!-- Botón -->
                <div class="col-12 text-center mb-4">
                    <button type="submit" class="btn btn-light" style="background-color: #a4ff9d !important;">Confirmar Información</button>
                    <a href="/<?= $_SESSION['rootFolder'] ?>/Usuario/getUsuario?id=<?= $usuario['id_usuario']; ?>" class="btn btn-ligth" style="background-color: #ffbd64 !important;">Cancelar</a>
                </div>

                <hr>
            </form>
        </section>

         </main>
             <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    //Hace aparecer el form de editar y desaparece el boton
                    const editButton = document.getElementById('editButton');
                    editButton.addEventListener("click", () => {

                        const editForm = document.getElementById('editForm');
                        editForm.style.display = "block";
                        editButton.style.display = "none";
                    });
                    checkbox.addEventListener('change', toggleFileInput);
                    toggleFileInput();
                 </script>

    </body>

</html>
