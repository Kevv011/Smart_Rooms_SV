<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Añadir alojamiento</title>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!--NAVBAR-->

    <main class="container mb-3" style="margin-top: 9rem">
        <div class=" shadow-lg rounded-4">
            <div class="card-header text-center text-dark rounded-top-4">
                <h3 class="my-2 pt-3">Registrar Alojamiento</h3>
            </div>

            <div class="card-body p-4">
                <form action="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/create" method="POST" enctype="multipart/form-data" class="row g-4">

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Alojamiento</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <!-- Descripción -->
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>

                    <!-- Anfitrión -->
                    <div class="col-md-6">
                        <label for="anfitrion" class="form-label">Anfitrión</label>
                        <div class="input-group">
                            <span class="input-group-text m-0">
                                <a class="p-0 m-0" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Agrega un anfitrión si no existe">
                                    <button type="button" class="btn m-0 p-0" data-bs-toggle="modal" data-bs-target="#modalAnfitrion">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </button>
                                </a>
                            </span>
                            <select class="form-select text-capitalize" name="id_anfitrion" id="anfitrion" required>
                                <option value="" selected disabled>Selecciona un anfitrión...</option>
                                <?php if (!empty($anfitriones)) {
                                    foreach ($anfitriones as $anfitrion) { ?>
                                        <option value="<?= htmlspecialchars($anfitrion['id_anfitrion']) ?>">
                                            <?= htmlspecialchars($anfitrion['nombre'] . ' ' . $anfitrion['apellido']) ?>
                                        </option>
                                    <?php }
                                } else { ?>
                                    <option disabled>No hay anfitriones disponibles</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>

                    <!-- Precio -->
                    <div class="col-md-3">
                        <label for="precio" class="form-label">Precio por noche</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="precio" name="precio" min="1" required>
                        </div>
                    </div>

                    <!-- Departamento -->
                    <div class="col-md-3">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="departamento" name="departamento" required>
                            <option disabled selected>Selecciona un departamento...</option>
                            <?php
                            $departamentos = ["ahuachapan", "santa ana", "sonsonate", "chalatenango", "la libertad", "san salvador", "cuscatlan", "la paz", "cabañas", "san vicente", "usulutan", "san miguel", "morazan", "la union"];
                            foreach ($departamentos as $dep) {
                                $selected = $dep === "san salvador" ? "selected" : "";
                                echo "<option value=\"$dep\" $selected>" . ucwords($dep) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Capacidad -->
                    <div class="col-md-3">
                        <label for="minpersona" class="form-label">Min. Personas</label>
                        <input type="number" class="form-control" id="minpersona" name="minpersona" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label for="maxpersona" class="form-label">Max. Personas</label>
                        <input type="number" class="form-control" id="maxpersona" name="maxpersona" min="1" required>
                    </div>

                    <!-- Imagen -->
                    <div class="col-12 col-md-10">
                        <label for="imagen" class="form-label">Imagen del Alojamiento</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>

                    <!-- Mascotas -->
                    <div class="col-md-2 text-center">
                        <label class="form-label d-block">¿Acepta mascotas?</label>
                        <div class="btn-group" role="group" aria-label="Mascotas">
                            <input type="radio" class="btn-check" name="mascota" value="1" id="afirmar" autocomplete="off">
                            <label class="btn btn-outline-success" for="afirmar">Sí</label>

                            <input type="radio" class="btn-check" name="mascota" value="0" id="denegar" checked autocomplete="off">
                            <label class="btn btn-outline-danger" for="denegar">No</label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary px-4">Confirmar Información</button>
                        <button type="button" class="btn btn-secondary px-4" data-bs-toggle="modal" data-bs-target="#modalCancelar">Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </main>

    <!--Modal de confirmacion de boton "cancelar"-->
    <div class="modal fade" id="modalCancelar" aria-hidden="true" aria-labelledby="LabelDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="LabelDelete">Cancelar registro</h1>
                </div>
                <div class="modal-body">
                    ¿Está seguro de cancelar el registro de este Alojamiento?
                </div>
                <div class="modal-footer">
                    <!-- Botones -->
                    <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/alojamientos" class="btn btn-success">Confirmar</a>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal si se quiere crear un nuevo anfitrion-->
    <div class="modal fade" id="modalAnfitrion" aria-hidden="true" aria-labelledby="LabelDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="LabelDelete">Crear nuevo anfitrión</h1>
                </div>
                <div class="modal-body">
                    Se procedera con la creación de un nuevo anfitrión y se cancelara el registro del alojamiento...
                </div>
                <div class="modal-footer">
                    <!-- Botones -->
                    <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/alojamientos" class="btn btn-success">Confirmar</a>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!--BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!--Habilitar Tooltips de Bootstrap-->
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

</body>

</html>