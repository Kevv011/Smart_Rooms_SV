<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Reservación</title>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container mb-3" style="margin-top: 150px;">

        <div class="d-flex justify-content-between">
            <a href="/<?= $_SESSION['rootFolder'] ?>/Reservation/mis_reservaciones" class="btn btn-dark"> ← Regresar</a>

            <?php if ($_SESSION['user_role'] === 'administrador'): ?>
                <div>
                    <button type="button" class="btn btn-secondary"><i class="fa-solid fa-calendar-days"></i> Verificar fechas</button>
                    <button type="button" class="btn btn-success"><i class="fa-solid fa-pencil"></i> Editar</button>
                </div>
            <?php endif; ?>
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
        </div>
    </main>

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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $infoAlojamiento['id']; ?>";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $infoAlojamiento['id']; ?>";
                });
            }
        </script>
    <?php endif; ?>
</body>

</html>