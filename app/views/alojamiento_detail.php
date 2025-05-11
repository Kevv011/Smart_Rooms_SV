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
        <!-- Título -->
        <h2 class="mb-4 text-center text-lg-start text-capitalize"><?= htmlspecialchars($alojamiento['nombre']); ?></h2>

        <!-- Imagen principal -->
        <div class="text-center mb-4">
            <img src="<?= "/" . $_SESSION['rootFolder'] . htmlspecialchars($alojamiento['imagen']); ?>"
                class="img-fluid rounded shadow-sm"
                alt="<?= htmlspecialchars($alojamiento['nombre']); ?>"
                style="max-height: 400px; object-fit: cover; width: 100%;">
        </div>

        <!-- Detalles y cuadro de reserva -->
        <div class="row g-4">
            <!-- Detalles -->
            <div class="col-lg-8">
                <div class="card-body p-0">
                    <p class="card-text fst-italic fs-5 pb-1"><?= htmlspecialchars($alojamiento['descripcion']); ?></p>

                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><strong>Dirección:</strong> <?= htmlspecialchars($alojamiento['direccion']); ?></li>
                        <li class="mb-2"><strong>Departamento y/o ciudad:</strong> <?= htmlspecialchars($alojamiento['departamento']); ?></li>
                        <li class="mb-2"><strong>Capacidad:</strong> De <?= htmlspecialchars($alojamiento['minpersona']); ?> a <?= htmlspecialchars($alojamiento['maxpersona']); ?> personas.</li>
                        <li class="mb-2"><strong>¿Acepta Mascotas?:</strong> <?= ($alojamiento['mascota'] == 1) ? "Sí" : "No"; ?></li>
                    </ul>
                </div>

                <!-- Mapa ubicacion del alojamiento -->
                <div id="map" style="height: 400px;"><!--Contenido cargado con JS al final y una API-KEY de Google--></div>
            </div>

            <!-- Cuadro de reserva -->
            <div class="col-lg-4">
                <div class="card shadow p-4 bg-white">
                    <h4 class="mb-3">
                        <strong>$<?= htmlspecialchars($alojamiento['precio']); ?> USD</strong>
                        <span class="fw-normal fs-6 text-muted">por noche</span>
                    </h4>

                    <div class="border rounded">
                        <div class="row g-0">
                            <!-- Huéspedes -->
                            <div class="col-12 border-top p-3">
                                <label class="text-uppercase small text-muted mb-1">Huéspedes</label>
                                <select class="form-select border-0 p-1">
                                    <?php for ($i = $alojamiento['minpersona']; $i <= $alojamiento['maxpersona']; $i++) {
                                        echo "<option> $i huésped/es</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!--Botones para CLIENTES-->
                    <?php if (!isset($_SESSION['user_role'])) { ?>
                        <button class="btn w-100 mt-3 text-white" data-bs-toggle="modal" data-bs-target="#login" style="background: linear-gradient(to right,rgb(56, 109, 255),rgb(0, 218, 247)); border: none;">
                            Reservar
                        </button>

                    <?php } else { ?>

                        <!--Botones para el ADMINISTRADOR-->
                        <?php if ($_SESSION['user_role'] === "administrador") { ?>
                            <?php if ($alojamiento['eliminado'] == FALSE) { ?>
                                <button type="button" id="editButton" class="btn w-100 mt-3 text-white mb-2" style="background: linear-gradient(to right,rgb(56, 109, 255),rgb(0, 218, 247)); border: none;">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Editar
                                </button>
                                <button type="button" class="btn btn-danger text-white mt-2" data-bs-toggle="modal" data-bs-target="#modalDelete"> <i class="fa-solid fa-trash me-1"></i>Eliminar</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary text-white mt-2" data-bs-toggle="modal" data-bs-target="#modalDelete"> <i class="fa-solid fa-trash-can-arrow-up"></i> Restaurar</button>

                                <!--Botones para USUARIOS-->
                            <?php }
                        } else { ?>
                            <button type="button" class="btn btn-danger text-white mt-2" data-bs-toggle="modal" data-bs-target="#modalFavorito"> <i class="fa-solid fa-heart"></i> Agregar a favorito</button>

                            <form action="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/reservacion_alojamiento" method="POST">

                                <!-- Input HIDDEN para enviar ID del alojamiento a la reservacion -->
                                <input type="hidden" name="id_alojamiento" value="<?= $alojamiento['id'] ?>">
                                <button type="submit" class="btn w-100 mt-3 text-white" style="background: linear-gradient(to right,rgb(56, 109, 255),rgb(0, 218, 247)); border: none;">
                                    Reservar
                                </button>
                            </form>
                    <?php }
                    } ?>
                </div>

                <!-- Información del anfitrión -->
                <?php if (!empty($userAnfitrion)) { ?>
                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i>Información del Anfitrión</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2 text-capitalize d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-user fs-5"></i>
                                <?= htmlspecialchars($userAnfitrion['nombre_usuario']) ?> <?= htmlspecialchars($userAnfitrion['apellido']) ?>
                            </p>
                            <p class="mb-2 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-envelope fs-5"></i>
                                <a href="mailto:<?= htmlspecialchars($userAnfitrion['correo']) ?>">
                                    <?= htmlspecialchars($userAnfitrion['correo']) ?>
                                </a>
                            </p>
                            <p class="mb-2 d-flex align-items-center gap-2">
                                <i class="fa-solid fa-phone"></i>
                                <a href="tel:<?= htmlspecialchars($userAnfitrion['telefono']) ?>">
                                    <?= htmlspecialchars($userAnfitrion['telefono']) ?>
                                </a>
                            </p>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>No se encontró información del anfitrión.
                    </div>
                <?php } ?>
            </div>
        </div>

        <section id="editForm" class="mt-3" style="display: none;">

            <hr>

            <form action="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/update" method="POST" enctype="multipart/form-data" class="row g-3 mt-3">

                <!-- id -->
                <input type="text" name="id" value="<?= htmlspecialchars($alojamiento['id']); ?>" hidden>

                <!-- Nombre -->
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre del Alojamiento</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($alojamiento['nombre']); ?>" required>
                </div>

                <!-- Descripción -->
                <div class="col-md-6">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($alojamiento['descripcion']); ?>" required>
                </div>

                <!-- Dirección -->
                <div class="col-8">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($alojamiento['direccion']); ?>" required>
                </div>

                <!-- latitud ubicacion -->
                <div class="col-md-2">
                    <label for="precio" class="form-label">Latitud</label>
                    <div class="input-group">
                        <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Coordenada de ubicación: [Latitud, longitud]"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="number" class="form-control" id="precio" name="latitud" value="<?= htmlspecialchars($alojamiento['latitud']); ?>" step="0.00000001" placeholder="Ej: 13.692940" required>
                    </div>
                </div>

                <!-- longitud ubicacion -->
                <div class="col-md-2">
                    <label for="precio" class="form-label">longitud</label>
                    <div class="input-group">
                        <span class="input-group-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Coordenada de ubicación: [Latitud, longitud]"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="number" class="form-control" id="precio" name="longitud" value="<?= htmlspecialchars($alojamiento['longitud']); ?>" step="0.00000001" placeholder="Ej: -89.218191" required>
                    </div>
                </div>

                <!-- Precio -->
                <div class="col-md-2">
                    <label for="precio" class="form-label">Precio por noche</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($alojamiento['precio']); ?>" min="1" step="0.01" required>
                    </div>
                </div>

                <!-- Departamento -->
                <div class="col-md-4">
                    <label for="departamento" class="form-label">Departamento</label>
                    <select class="form-select" id="departamento" name="departamento" required>
                        <option value="<?= htmlspecialchars($alojamiento['departamento']); ?>" selected><?= htmlspecialchars($alojamiento['departamento']); ?></option>
                        <option value="ahuachapan">Ahuachapán</option>
                        <option value="santa ana">Santa Ana</option>
                        <option value="sonsonate">Sonsonate</option>
                        <option value="chalatenango">Chalatenango</option>
                        <option value="la libertad">La Libertad</option>
                        <option value="san salvador">San Salvador</option>
                        <option value="cuscatlan">Cuscatlán</option>
                        <option value="la paz">La Paz</option>
                        <option value="cabañas">Cabañas</option>
                        <option value="san vicente">San Vicente</option>
                        <option value="usulutan">Usulután</option>
                        <option value="san miguel">San Miguel</option>
                        <option value="morazan">Morazán</option>
                        <option value="la union">La Unión</option>
                    </select>
                </div>

                <!-- Personas mínimas -->
                <div class="col-6 col-md-2">
                    <label for="minpersona" class="form-label">Min persona</label>
                    <input type="number" class="form-control" id="minpersona" name="minpersona" value="<?= htmlspecialchars($alojamiento['minpersona']); ?>" min="1" required>
                </div>

                <!-- Personas máximas -->
                <div class="col-6 col-md-2">
                    <label for="maxpersona" class="form-label">Max persona</label>
                    <input type="number" class="form-control" id="maxpersona" name="maxpersona" value="<?= htmlspecialchars($alojamiento['maxpersona']); ?>" min="1" required>
                </div>

                <!-- Mascota -->
                <div class="col-md-2 text-center">
                    <label class="form-label d-block">¿Acepta mascotas?</label>
                    <div class="btn-group" role="group" aria-label="Mascotas">
                        <input type="radio" class="btn-check" name="mascota" value="1" id="afirmar" autocomplete="off">
                        <label class="btn btn-outline-success" for="afirmar">Sí</label>

                        <input type="radio" class="btn-check" name="mascota" value="0" id="denegar" checked autocomplete="off">
                        <label class="btn btn-outline-danger" for="denegar">No</label>
                    </div>
                </div>

                <div class="row my-4">
                    <!-- Imagen -->
                    <div class="col-md-8 mb-3 d-flex flex-column justify-content-center align-items-center gap-3 border-end pe-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="checkImage" value="1" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                            <label class="form-check-label" for="flexSwitchCheckChecked">¿Cambiar imagen?</label>
                        </div>
                        <div class="col-md-10">
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                            <input type="hidden" id="imagenValue" name="imgValue" value="1">
                        </div>
                    </div>

                    <!-- Anfitrión -->
                    <div class="col-md-4 d-flex flex-column justify-content-center gap-2">
                        <label for="anfitrion" class="form-label">Anfitrión</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-plus"></i></span>

                            <select class="form-select text-capitalize" name="id_anfitrion" id="anfitrion" required>
                                <option value="<?= htmlspecialchars($userAnfitrion['id_anfitrion']) ?>" selected><?= htmlspecialchars($userAnfitrion['nombre_usuario']) ?> <?= htmlspecialchars($userAnfitrion['apellido']) ?></option>
                                <?php if (!empty($anfitriones) && !$userAnfitrion['id_anfitrion']) {
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
                </div>

                <!-- Botón -->
                <div class="col-12 text-center mb-4">
                    <button type="submit" class="btn btn-light" style="background-color: #a4ff9d !important;">Confirmar Información</button>
                    <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $alojamiento['id']; ?>" class="btn btn-ligth" style="background-color: #ffbd64 !important;">Cancelar</a>
                </div>

                <hr>
            </form>
        </section>
    </main>

    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->


    <!--Modal de eliminacion o restauracion-->
    <div class="modal fade" id="modalDelete" aria-hidden="true" aria-labelledby="LabelDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!--Si se va a eliminar el Alojamiento-->
                <?php if ($alojamiento['eliminado'] == FALSE) { ?>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="LabelDelete">Eliminar Alojamiento</h1>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de eliminar este Alojamiento? Este sera movido a alojamientos eliminados...
                    </div>
                    <div class="modal-footer">
                        <form action="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/softDelete/" method="POST">

                            <!-- id -->
                            <input type="text" name="idDelete" value="<?= htmlspecialchars($alojamiento['id']); ?>" hidden>

                            <!-- Botones -->
                            <button type="submit" class="btn btn-success">Confirmar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>

                    <!--Si se va a restaurar el Alojamiento (Permiso de Administrador)-->
                <?php } else { ?>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="LabelDelete">Restaurar Alojamiento</h1>
                    </div>
                    <div class="modal-body">
                        ¿Restaurar este Alojamiento? Ahora este será disponible a todo el público
                    </div>
                    <div class="modal-footer">
                        <form action="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/restore/" method="POST">

                            <!-- id -->
                            <input type="text" name="idRestore" value="<?= htmlspecialchars($alojamiento['id']); ?>" hidden>

                            <!-- Botones -->
                            <button type="submit" class="btn btn-success">Confirmar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar la agregacion como favorito -->
    <div class="modal fade" id="modalFavorito" tabindex="-1" aria-labelledby="labelFavorito" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="mb-3">¿Agregar alojamiento como favorito?</p>

                    <form action="/<?= $_SESSION['rootFolder'] ?>/Alojamiento_favorito/favoritos/" method="POST">

                        <!-- id_alojamiento -->
                        <input type="text" name="id_alojamiento" value="<?= htmlspecialchars($alojamiento['id']); ?>" hidden>

                        <!-- Botones -->
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Agregar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div class="d-flex justify-content-center gap-3">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        //Hace aparecer el form de editar y desaparece el boton
        const editButton = document.getElementById('editButton');
        editButton.addEventListener("click", () => {

            const editForm = document.getElementById('editForm');
            editForm.style.display = "block";
            editButton.style.display = "none";
        });

        //Identificar si se quiere cambiar imagen o no
        const checkbox = document.querySelector('.form-check-input');
        const inputFile = document.getElementById('imagen');
        const imgValue = document.getElementById('imagenValue');

        function toggleFileInput() {
            if (checkbox.checked) {
                inputFile.disabled = false;
                imagenValue.value = 1; //Si se habilita el check, el input hidden indica el procesamiento de una nueva imagen
            } else {
                inputFile.disabled = true;
                imagenValue.value = "<?= htmlspecialchars($alojamiento['imagen']); ?>"; //Si se deshabilita, el input hidden retorna la misma ruta de la imagen
            }
        }
        checkbox.addEventListener('change', toggleFileInput);
        toggleFileInput();
    </script>

    <!-- Manejo de la ubicacion con un mapa de Google bajo el uso de una API-KEY -->
    <script>
        function initMap() {
            const ubicacion = {
                lat: <?= $alojamiento['latitud']; ?>,
                lng: <?= $alojamiento['longitud']; ?>
            };
            const mapa = new google.maps.Map(document.getElementById("map"), {
                zoom: 17,
                center: ubicacion,
            });

            const marker = new google.maps.Marker({
                position: ubicacion,
                map: mapa,
                title: "Ubicación del alojamiento"
            });

            const enlace = `https://www.google.com/maps/dir/?api=1&destination=${ubicacion.lat},${ubicacion.lng}`;

            const info = new google.maps.InfoWindow({
                content: `<a href="${enlace}" target="_blank">¿Cómo llegar?</a>`
            });

            marker.addListener("click", () => {
                info.open(mapa, marker);
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7GVWPPzUnk2onLwxW7hCWQw11jnHyN0s&callback=initMap"></script>

    <!-- Manejo de alertas -->
    <?php if (isset($_GET['alert'])): ?>
        <script>
            let alertType = "<?php echo $_GET['alert']; ?>";
            let alertMessage = "<?php echo urldecode($_GET['message']); ?>";

            // Mostrar la alerta con SweetAlert
            if (alertType === "success") {
                Swal.fire({
                    title: '¡Éxito!',
                    text: alertMessage,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $alojamiento['id']; ?>";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $alojamiento['id']; ?>";
                });
            }
        </script>
    <?php endif; ?>
</body>

</html>