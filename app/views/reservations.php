<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones</title>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container mb-3" style="margin-top: 150px;">

        <!-- Reservaciones mostrados POR CLIENTE -->
        <?php if ($_SESSION['user_role'] === 'cliente'): ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-id-user" class="form-label col-4">ID</label>
                            <input type="number" id="filtro-id-user" placeholder="ID" class="form-control col-8">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-nombre-user" class="form-label col-4">Alojamiento</label>
                            <input type="text" id="filtro-nombre-user" placeholder="Nombre" class="form-control col-8">
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-fecha-reservacion-user" class="form-label col-6">Fecha reservacion</label>
                            <input type="date" id="filtro-fecha-reservacion-user" class="form-control col-6">
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover mt-4 text-center ">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th class="d-none d-md-table-cell">Imagen</th>
                        <th>Alojamiento</th>
                        <th>Fecha de Reservación</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($reservaciones)): ?>
                        <?php foreach ($reservaciones as $reserva): ?>
                            <tr class="reserva-user-row"
                                data-id="<?= htmlspecialchars($reserva['id']) ?>"
                                data-nombre="<?= strtolower(htmlspecialchars($reserva['nombre_alojamiento'])) ?>"
                                data-fecha="<?= date('Y-m-d', strtotime($reserva['fecha_reservacion'])) ?>">

                                <td><?= htmlspecialchars($reserva['id']) ?></td>
                                <td class="d-none d-md-table-cell">
                                    <?php if (!empty($reserva['imagen'])): ?>
                                        <img src="/<?= $_SESSION['rootFolder'] ?>/<?= htmlspecialchars($reserva['imagen']) ?>" alt="Imagen" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        <span class="text-muted">Sin imagen</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($reserva['nombre_alojamiento']) ?></td>
                                <td><?= date("d/m/Y", strtotime($reserva['fecha_reservacion'])) ?></td>
                                <td>
                                    <span class="badge text-dark <?= $reserva['estado'] === 'pendiente' ? 'bg-warning' : ($reserva['estado'] === 'confirmada' ? 'bg-success' : ($reserva['estado'] === 'cancelada' ? 'bg-danger' : 'bg-secondary')) ?>">
                                        <?= ucfirst($reserva['estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="/<?= $_SESSION['rootFolder'] ?>/Reservation/post_reservacion_alojamiento" method="POST">
                                        <input type="hidden" name="id_reservacion" value="<?= $reserva['id'] ?>">
                                        <input type="hidden" name="id_alojamiento" value="<?= $reserva['id_alojamiento'] ?>">
                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-eye"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron reservaciones.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <p id="no-match-user" class="text-center mt-3 text-muted" style="display: none;">
                No se han encontrado resultados.
            </p>

            <!-- Reservaciones mostrados al ADMINISTRADOR y EMPLEADOS -->

            <!-- Filtros para clasificar las reservaciones en el perfil de administrador -->
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-id-admin" class="form-label col-4">ID</label>
                            <input type="number" id="filtro-id-admin" placeholder="ID" class="form-control col-8">
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-fecha-reservacion-admin" class="form-label col-8">Fecha reservación</label>
                            <input type="date" id="filtro-fecha-reservacion-admin" class="form-control col-4">
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-nombre-admin" class="form-label col-6">Alojamiento</label>
                            <input type="text" id="filtro-nombre-admin" placeholder="Nombre" class="form-control col-6">
                        </div>

                        <div class="col-lg-2 col-md-6 col-sm-12 mb-2 align-items-center">
                            <label for="filtro-entrada-admin" class="form-label col-6">Entrada</label>
                            <input type="date" id="filtro-entrada-admin" class="form-control col-6">
                        </div>

                        <div class="col-lg-2 col-md-12 col-sm126 mb-2 align-items-center">
                            <label for="filtro-salida-admin" class="form-label col-6">Salida</label>
                            <input type="date" id="filtro-salida-admin" class="form-control col-6">

                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">

                <table class="table table-hover mt-4 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha reservación</th>
                            <th>Alojamiento</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($reservacionesAdmin)): ?>
                            <?php foreach ($reservacionesAdmin as $reserva): ?>
                                <tr class="reserva-admin-row"
                                    data-id="<?= htmlspecialchars($reserva['id']) ?>"
                                    data-fecha-reservacion="<?= date('Y-m-d', strtotime($reserva['fecha_reservacion'])) ?>"
                                    data-nombre="<?= strtolower(htmlspecialchars($reserva['nombre_alojamiento'])) ?>"
                                    data-entrada="<?= date('Y-m-d', strtotime($reserva['fecha_entrada'])) ?>"
                                    data-salida="<?= date('Y-m-d', strtotime($reserva['fecha_salida'])) ?>">

                                    <td><?= htmlspecialchars($reserva['id']) ?></td>
                                    <td><?= date("d/m/Y", strtotime($reserva['fecha_reservacion'])) ?></td>
                                    <td><?= htmlspecialchars($reserva['nombre_alojamiento']) ?></td>
                                    <td><?= date("d/m/Y", strtotime($reserva['fecha_entrada'])) ?></td>
                                    <td><?= date("d/m/Y", strtotime($reserva['fecha_salida'])) ?></td>
                                    <td>
                                        <span class="badge text-dark <?= $reserva['estado'] === 'pendiente' ? 'bg-warning' : ($reserva['estado'] === 'confirmada' ? 'bg-success' : ($reserva['estado'] === 'cancelada' ? 'bg-danger' : 'bg-secondary')) ?>">
                                            <?= ucfirst($reserva['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="/<?= $_SESSION['rootFolder'] ?>/Reservation/post_reservacion_alojamiento" method="POST">
                                            <input type="hidden" name="id_reservacion" value="<?= $reserva['id'] ?>">
                                            <input type="hidden" name="id_alojamiento" value="<?= $reserva['id_alojamiento'] ?>">
                                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-eye"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron reservaciones.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p id="no-match-admin" class="text-center mt-3 text-muted" style="display: none;">
                    No se han encontrado resultados.
                </p>
            </div>
        <?php endif; ?>
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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/mis_reservaciones";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/mis_reservaciones";
                });
            }
        </script>
    <?php endif; ?>

    <script src="/<?= $_SESSION['rootFolder'] ?>/public/js/search-users.js"></script> <!-- Manejo de la barra de busqueda de reservaciones para usuarios -->
    <script src="/<?= $_SESSION['rootFolder'] ?>/public/js/search-admins.js"></script> <!-- Manejo de la barra de busqueda de reservaciones para admins-->

</body>

</html>