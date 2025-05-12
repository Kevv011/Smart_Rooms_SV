<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Reservación</title>

    <style>
        .star {
            font-size: 3rem;
            color: lightgray;
            cursor: pointer;
            transition: color 0.2s;
        }

        input[type="radio"] {
            display: none;
        }

        #rating-stars label:hover,
        #rating-stars input[type="radio"]:checked~label,
        #rating-stars label:hover~label {
            color: gold;
        }

        /* Al seleccionar, pintar todas las anteriores también */
        #rating-stars input[type="radio"]:checked~label {
            color: lightgray;
        }

        #rating-stars input[type="radio"]:checked+label,
        #rating-stars input[type="radio"]:checked+label~label {
            color: gold;
        }

        #rating-stars label:hover,
        #rating-stars label:hover~label {
            color: gold;
        }
    </style>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container mb-3" style="margin-top: 150px;">

        <div class="d-flex justify-content-between">
            <a href="/<?= $_SESSION['rootFolder'] ?>/Reservation/reservaciones" class="btn btn-dark"> ← Regresar</a>


            <div>
                <?php if ($_SESSION['user_role'] === 'administrador'): ?>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editReservacion"><i class="fa-solid fa-pencil"></i> + Asignar</button>
                <?php endif; ?>

                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#logReservacion"><i class="fa-solid fa-book-open"></i> Detalles de seguimiento</button>
            </div>

        </div>

        <div class="container mt-1">
            <section class="container my-3">
                <div class="row">
                    <!-- Columna: Detalles del alojamiento -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <!-- Imagen solo visible en pantallas grandes -->
                            <img src="/<?= $_SESSION['rootFolder'] ?><?= $alojamientoById['imagen'] ?>"
                                class="card-img-top d-none d-lg-block"
                                alt="<?= $alojamientoById['nombre'] ?>">

                            <div class="card-body d-flex flex-column flex-md-row align-items-center align-items-md-start">
                                <img src="/<?= $_SESSION['rootFolder'] ?><?= $alojamientoById['imagen'] ?>"
                                    class="img-thumbnail me-3 d-block d-lg-none"
                                    style="width: 150px; height: auto; object-fit: cover;"
                                    alt="<?= $alojamientoById['nombre'] ?>">

                                <div class="flex-grow-1">
                                    <h5 class="card-title"><?= $alojamientoById['nombre'] ?></h5>

                                    <p class="card-text mb-1">
                                        <strong>Dirección:</strong> <?= $alojamientoById['direccion'] ?>
                                    </p>

                                    <p class="card-text mb-1">
                                        <strong>Precio:</strong> $<?= number_format($alojamientoById['precio'], 2) ?>
                                    </p>

                                    <p class="card-text mb-1">
                                        <strong>Capacidad:</strong> <?= $alojamientoById['minpersona'] ?> - <?= $alojamientoById['maxpersona'] ?> personas
                                    </p>

                                    <p class="card-text mb-0">
                                        <?php if ($alojamientoById['estado_reservado']) { ?>
                                            <span class="badge bg-success mt-2">Disponible</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger mt-2">Reservado</span>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna: Detalle de reservación -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-4">Detalle de reservación</h4>
                                    <span class="badge text-dark
                                        <?= $reservacionById['estado'] === 'pendiente' ? 'bg-warning' : ($reservacionById['estado'] === 'confirmada' ? 'bg-success' : ($reservacionById['estado'] === 'cancelada' ? 'bg-danger' : 'bg-secondary')) ?>">
                                        <?= ucfirst($reservacionById['estado']) ?>
                                    </span>
                                </div>

                                <section class="row g-3">
                                    <?php if ($_SESSION['user_role'] === 'administrador'): ?>
                                        <div class="col-12">
                                            <p class="text-capitalize"><strong>Cliente: </strong><?= $reservacionById['nombre_user'] ?> <?= $reservacionById['apellido_user'] ?></p>
                                            <p><strong>Correo: </strong><?= $reservacionById['email_user'] ?></p>
                                            <p><strong>Telefono: </strong><?= $reservacionById['telefono_user'] ?></p>
                                        </div>

                                        <hr>
                                    <?php endif; ?>

                                    <!-- Número de huéspedes -->
                                    <div class="col-md-6">
                                        <p><strong>Número de huéspedes: </strong><?= $reservacionById['huéspedes'] ?></p>
                                    </div>

                                    <!-- Fecha de entrada -->
                                    <div class="col-md-6">
                                        <p><strong>Fecha de entrada: </strong><?= date("d/m/Y", strtotime($reservacionById['fecha_entrada'])) ?></p>
                                    </div>

                                    <!-- Fecha de salida -->
                                    <div class="col-md-6">
                                        <p><strong>Fecha de Salida: </strong><?= date("d/m/Y", strtotime($reservacionById['fecha_salida'])) ?></p>
                                        <?php if ($reservacionById['estado'] === 'completada'): ?>
                                            <p><strong>Fecha de Salida (real): </strong><?= date("d/m/Y", strtotime($reservacionById['fecha_salida_real'])) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Método de pago -->
                                    <div class="col-md-6">
                                        <p class="text-capitalize"><strong>Método de pago: </strong><?= $reservacionById['metodo_pago'] ?></p>
                                    </div>
                                </section>
                                <hr>
                                <section>
                                    <div class="col-12">
                                        <p class="fs-4"><strong>Total: </strong>$<?= $reservacionById['total_pago'] ?></p>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <!-- Información del anfitrión -->
                        <?php if (!empty($anfitrionById)) { ?>
                            <div class="card shadow-sm border-0 mt-4">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i>Información del Anfitrión</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2 text-capitalize d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-circle-user fs-5"></i>
                                        <?= htmlspecialchars($anfitrionById['nombre_usuario']) ?> <?= htmlspecialchars($anfitrionById['apellido']) ?>
                                    </p>
                                    <p class="mb-2 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-envelope fs-5"></i>
                                        <a href="mailto:<?= htmlspecialchars($anfitrionById['correo']) ?>">
                                            <?= htmlspecialchars($anfitrionById['correo']) ?>
                                        </a>
                                    </p>
                                    <p class="mb-2 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-phone"></i>
                                        <a href="tel:<?= htmlspecialchars($anfitrionById['telefono']) ?>">
                                            <?= htmlspecialchars($anfitrionById['telefono']) ?>
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
            </section>

            <?php if ($_SESSION['user_role'] !== 'administrador' && $_SESSION['user_role'] !== 'empleado'): ?>
                <?php if ($reservacionById['estado'] === 'completada'): ?>

                    <!-- Muestra del comentario y puntuacion con estrellas al haberse realizado -->
                    <?php if (!is_null($reservacionById['calificacion_usuario'])): ?>

                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Tu experiencia calificada</h4>
                                <hr>
                                <div class="row align-items-center">
                                    <!-- Columna de calificación -->
                                    <div class="col-12 col-md-4 d-flex align-items-center mb-3 mb-md-0">
                                        <span class="fw-semibold me-2">Calificación:</span>
                                        <div class="d-flex gap-1">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="star" style="font-size: 1.5rem; color: <?= $i <= $reservacionById['calificacion_usuario'] ? '#ffc107' : '#e4e5e9' ?>">&#9733;</span>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <!-- Columna de comentario -->
                                    <div class="col-12 col-md-8">
                                        <span class="fw-semibold">Comentario:</span>
                                        <?php if (!empty($reservacionById['comentario_usuario'])): ?>
                                            <p class="mb-0"><?= nl2br(htmlspecialchars($reservacionById['comentario_usuario'])) ?></p>
                                        <?php else: ?>
                                            <p class="mb-0">Sin comentarios</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form para detallar un comentario y puntuacion con estrellas si la reservacion ha sido completada -->
                    <?php else: ?>
                        <h1>¡Califica tu experiencia!</h1>

                        <form action="/<?= $_SESSION['rootFolder'] ?>/Reservation/calificacionUsuario" method="POST">
                            <input type="hidden" name="id_reservacion" value="<?= $reservacionById['id'] ?>">
                            <input type="hidden" name="id_alojamiento" value="<?= $alojamientoById['id'] ?>">

                            <div class="mb-3">
                                <label for="calificacion" class="form-label">Tu calificación:</label>
                                <div id="rating-stars" class="d-flex justify-content-start gap-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <input type="radio" name="calificacion" id="estrella<?= $i ?>" value="<?= $i ?>" required />
                                        <label for="estrella<?= $i ?>" class="star" style="font-size: 2rem;">&#9733;</label>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="comentario" class="form-label">Comentario (opcional):</label>
                                <textarea name="comentario" id="comentario" class="form-control" rows="3" placeholder="Cuéntanos tu experiencia..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Enviar comentario</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>

            <?php else: ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Modal para editar y asignar la reservacion al cliente (ADMINISTRADOR) -->
    <div class="modal fade" id="editReservacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative d-flex justify-content-center align-items-center py-2">
                    <p class="text-black fs-3 fw-bold m-0 text-center w-100">Asignar reservación</p>
                    <button type="button" class="btn position-absolute end-0 me-3" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="p-3" action="/<?= $_SESSION['rootFolder'] ?>/Reservation/asignar_reservacion" method="POST">

                        <!-- ID de reservacion -->
                        <input type="hidden" value="<?= $reservacionById['id'] ?>" name="id_reservacion">

                        <!-- ID de alojamiento -->
                        <input type="hidden" value="<?= $alojamientoById['id'] ?>" name="id_alojamiento">

                        <!-- Estado de reservación -->
                        <div class="mb-3">
                            <label for="estado-select" class="form-label">Estado de la reservación</label>
                            <select id="estado-select" class="form-select" name="estado-select" required>

                                <?php if ($reservacionById['estado'] === 'confirmada'): ?>
                                    <option value="completada">Completar reservación</option>

                                <?php elseif ($reservacionById['estado'] === 'cancelada'): ?>
                                    <option value="cancelada">Reservación rechazada</option>

                                <?php elseif ($reservacionById['estado'] === 'completada'): ?>
                                    <option value="completada">Reservación completada</option>

                                <?php else: ?>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="confirmada">Confirmar reservación</option>
                                    <option value="cancelada">Rechazar reservación</option>
                                <?php endif; ?>

                            </select>
                        </div>

                        <!-- Fecha de salida real (Si la reservacion esta marcada como "confirmada" o "completada") -->
                        <?php if ($reservacionById['estado'] === 'confirmada' || $reservacionById['estado'] === 'completada'): ?>
                            <div class="mb-3">
                                <label for="fecha_salida" class="form-label">Fecha de salida</label>
                                <input type="date" id="fecha_salida" name="fecha_salida_real" class="form-control" value="<?= $reservacionById['fecha_salida_real'] ?>" required></input>
                            </div>
                        <?php endif; ?>

                        <!-- Sección de comentarios -->
                        <div class="mb-3">
                            <label for="comentario_reservacion" class="form-label">Comentario</label>
                            <textarea id="comentario_reservacion" name="comentario_reservacion" class="form-control" rows="4" placeholder="Escribe un comentario sobre la reservación..."></textarea>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver el log de actualizaciones a la reservacion -->
    <div class="modal fade" id="logReservacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative d-flex justify-content-center align-items-center py-1">
                    <p class="text-black fs-3 fw-bold m-0 text-center w-100">Detalles de seguimiento</p>
                    <button type="button" class="btn position-absolute end-0 me-3" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($logReservacion)): ?>
                        <ul>
                            <?php foreach ($logReservacion as $item): ?>
                                <li class="list-unstyled">
                                    <strong class="text-capitalize"><?= htmlspecialchars($item['nombre'] . ' ' . $item['apellido']) ?> (<?= htmlspecialchars($item['rol']) ?>):</strong>
                                    <?= htmlspecialchars($item['comentario']) ?>
                                    <br>
                                    <small>
                                        Estado: <?= $item['estado_asignado'] ?> |
                                        Fecha: <?= (new DateTime($item['fecha_comentario']))->format('d/m/y H:i:s') ?>
                                    </small>
                                    <hr>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No hay historial de actualizaciones para esta reservación.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/detalle_reservacion?alojamiento=<?= $alojamientoById['id']; ?>&reservacion=<?= $reservacionById['id'] ?>?>";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/detalle_reservacion?alojamiento=<?= $alojamientoById['id']; ?>&reservacion=<?= $reservacionById['id'] ?>?>";
                });
            }
        </script>
    <?php endif; ?>
</body>

</html>