
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-1">Panel de Control</h1>
                    <p class="text-muted">Bienvenido al sistema de gestión de tickets</p>
                </div>
                <div>
                    <a href="Views/selection/index.html" target="_blank" class="btn btn-primary">Panel Cliente</a>
                    <a href="Views/ticket-display/index.html" target="_blank" class="btn btn-primary">Panel General</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row">
        <!-- Tablas de Tickets por categoría (muestra ticket y caja que los atiende) -->
        <div class="col-12 mb-4">
            <?php
                // Obtener tickets desde la base de datos y clasificarlos para el panel
                $normalTickets = [];
                $customerTickets = [];
                $premiumTickets = [];

                try {
                    $pdo = new \Config\Conexion();
                    $pdo = $pdo->getConexion();

                        // Obtener tickets en cola: buscar por nombre de estado que contenga 'espera'
                        // (más robusto que asumir un id fijo, evita discrepancias entre entornos)
                        $sql = "SELECT t.id, t.ticket_code, s.name AS service_name, ct.name AS client_type_name, ts.name AS status_name
                            FROM Tickets t
                            LEFT JOIN Services s ON s.id = t.service_id
                            LEFT JOIN ClientTypes ct ON ct.id = t.client_type_id
                            LEFT JOIN TicketStatuses ts ON ts.id = t.status_id
                            WHERE LOWER(COALESCE(ts.name, '')) LIKE '%espera%'
                            ORDER BY t.id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $all = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                    foreach ($all as $row) {
                        $id = $row['id'];
                        $ticket_code = isset($row['ticket_code']) ? $row['ticket_code'] : $id;
                        $serviceName = isset($row['service_name']) ? $row['service_name'] : '';
                        $clientTypeName = isset($row['client_type_name']) ? $row['client_type_name'] : '';

                        // Clasificación heurística (ajustable según datos reales)
                        $ctLower = strtolower($clientTypeName);
                        $sLower = strtolower($serviceName);

                        // keep numeric id and show ticket_code separately
                        $item = ['id' => $id, 'code' => $ticket_code, 'caja' => $serviceName];

                        if (strpos($ctLower, 'prefer') !== false || strpos($ctLower, 'preferencial') !== false) {
                            $premiumTickets[] = $item;
                        } elseif (strpos($sLower, 'atenc') !== false || strpos($sLower, 'cliente') !== false || strpos($ctLower, 'atenc') !== false) {
                            $customerTickets[] = $item;
                        } else {
                            $normalTickets[] = $item;
                        }
                    }
                } catch (\Exception $e) {
                    // En caso de error con la BD, dejar arrays vacíos pero registrar para depuración
                    @file_put_contents(__DIR__ . '/../../APIR/logs/home_errors.log', '['.date('Y-m-d H:i:s').'] Home list error: '.$e->getMessage()."\n", FILE_APPEND);
                }
            ?>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-stat">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Normal</h6>
                                    <h3 class="mb-0"><?php echo count($normalTickets); ?></h3>
                                    <small class="text-muted">Tickets en cola</small>
                                </div>
                                <div class="stat-icon bg-primary"><i class="fas fa-ticket-alt"></i></div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($normalTickets as $tk){ ?>
                                            <tr>
                                                <td><strong>#<?php echo $tk['code']; ?></strong></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success tomar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>" data-caja="<?php echo $tk['caja']; ?>">Tomar</button>
                                                    <button type="button" class="btn btn-sm btn-danger cerrar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>">Cerrar</button>
                                                    <button type="button" class="btn btn-sm btn-warning cambiar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>">Cambiar Servicio</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card card-stat">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Atención al Cliente</h6>
                                    <h3 class="mb-0"><?php echo count($customerTickets); ?></h3>
                                    <small class="text-muted">Tickets en cola</small>
                                </div>
                                <div class="stat-icon bg-warning"><i class="fas fa-headset"></i></div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Caja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($customerTickets as $tk){ ?>
                                            <tr>
                                                <td><strong>#<?php echo $tk['code']; ?></strong></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success tomar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>" data-caja="<?php echo $tk['caja']; ?>">Tomar</button>
                                                    <button type="button" class="btn btn-sm btn-danger cerrar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>">Cerrar</button>
                                                    <button type="button" class="btn btn-sm btn-warning cambiar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>">Cambiar Servicio</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card card-stat">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Preferencial</h6>
                                    <h3 class="mb-0"><?php echo count($premiumTickets); ?></h3>
                                    <small class="text-muted">Tickets en cola</small>
                                </div>
                                <div class="stat-icon bg-info"><i class="fas fa-star"></i></div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Ticket</th>
                                            <th>Caja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($premiumTickets as $tk){ ?>
                                            <tr>
                                                <td><strong>#<?php echo $tk['code']; ?></strong></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success tomar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>" data-caja="<?php echo $tk['caja']; ?>">Tomar</button>
                                                    <button type="button" class="btn btn-sm btn-danger cerrar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>">Cerrar</button>
                                                    <button type="button" class="btn btn-sm btn-warning cambiar-btn" data-id="<?php echo $tk['id']; ?>" data-code="<?php echo $tk['code']; ?>">Cambiar Servicio</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Regreso de estilos: reglas específicas para Home (anteriormente en custom-themes.css) -->
<style>
/* ----------------------------- */
/* Estilos para Home: tickets y tablas */
/* ----------------------------- */

/* Card stat refinada */
.card-stat {
    background: var(--card-bg, #fff);
    border: 1px solid rgba(0,0,0,0.04);
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(14,30,37,0.06);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.card-stat:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(14,30,37,0.08); }

.card-stat .card-body { padding: 1rem; }

.stat-icon { width:46px; height:46px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:18px; color:#fff; }
.stat-icon.bg-primary { background: linear-gradient(135deg, var(--primary-color,#0d6efd), var(--primary-hover,#0b5ed7)); }
.stat-icon.bg-warning { background: linear-gradient(135deg, #ffb74d, #ff9800); }
.stat-icon.bg-info { background: linear-gradient(135deg, #20c997, #0dcaf0); }

/* Small tables inside stat cards */
.card-stat .table-sm { margin-bottom: 0; }
.card-stat .table-sm td, .card-stat .table-sm th { padding: .45rem .6rem; vertical-align: middle; }
.card-stat .table-sm thead th { font-weight:600; font-size:0.85rem; color:var(--text-color, #212529); border-bottom: none; }
.card-stat .table-sm tbody td { font-size:0.95rem; border-top: 1px dashed rgba(0,0,0,0.04); }
.card-stat .table-sm tbody tr:hover { background: rgba(13,110,253,0.03); }

/* Ticket small (kept for backward compatibility) */
.ticket-small { display:inline-flex; align-items:center; justify-content:center; min-width:72px; height:46px; border-radius:8px; padding:.35rem .6rem; box-shadow:0 2px 6px rgba(0,0,0,0.04); font-weight:700; transition:transform .18s ease, box-shadow .18s ease; }
.ticket-small:hover { transform:translateY(-3px); box-shadow:0 6px 14px rgba(0,0,0,0.08); }
.ticket-number-small { font-size:1rem; color:inherit; }

.ticket-small.ticket-normal { background:linear-gradient(135deg, #f0f7ff, #e5f0ff); color:#0d6efd; border-left:3px solid rgba(13,110,253,0.14); }
.ticket-small.ticket-customer { background:linear-gradient(135deg,#fff9f0,#fff3e6); color:#f57c00; border-left:3px solid rgba(245,124,0,0.14); }
.ticket-small.ticket-premium { background:linear-gradient(135deg,#fbf5ff,#f1e7fb); color:#7b1fa2; border-left:3px solid rgba(123,31,162,0.14); }

@media (max-width:576px) { .ticket-small { min-width:64px; height:44px;} .ticket-number-small { font-size:.95rem; } }

/* Visual tweaks for ticket tables */
.card-stat .table-sm tbody tr td:first-child { font-weight:700; }
.card-stat .table-sm tbody tr td:last-child { color:var(--secondary-color,#6c757d); }

</style>

<script>
    (function(){
        function apiUpdate(data){
            // include API credentials if needed when not logged in
            var payload = Object.assign({}, data);
            // If session does not exist for kiosk, you can pass uid/pw here. Otherwise omitted.
            return $.ajax({
                url: '/APIR/index.php?method=update_ticket',
                method: 'POST',
                data: payload,
                dataType: 'json'
            });
        }

        $(document).on('click', '.tomar-btn', function(){
            var id = $(this).data('id');
            if (!confirm('¿Tomar ticket '+id+' para atención?')) return;
            apiUpdate({ id: id, action: 'take' })
                .done(function(res){
                    if(res && res.success){
                        location.reload();
                    } else {
                        alert(res.message || 'Error actualizando ticket');
                    }
                }).fail(function(xhr){
                    alert('Error en la petición: ' + (xhr.responseJSON?.message || xhr.responseText || xhr.statusText));
                });
        });

        $(document).on('click', '.cerrar-btn', function(){
            var id = $(this).data('id');
            if (!confirm('¿Cerrar ticket '+id+'?')) return;
            apiUpdate({ id: id, action: 'close' })
                .done(function(res){
                    if(res && res.success){
                        location.reload();
                    } else {
                        alert(res.message || 'Error cerrando ticket');
                    }
                }).fail(function(xhr){
                    alert('Error en la petición: ' + (xhr.responseJSON?.message || xhr.responseText || xhr.statusText));
                });
        });

        $(document).on('click', '.cambiar-btn', function(){
            var id = $(this).data('id');
            var newService = prompt('Ingrese el ID del servicio destino (ej. 1 para Caja, 2 para Atención):');
            if (newService === null) return; // cancel
            newService = newService.trim();
            if (newService === '' || isNaN(newService)) { alert('ID de servicio inválido'); return; }
            if (!confirm('Cambiar servicio del ticket '+id+' al servicio id '+newService+'?')) return;
            apiUpdate({ id: id, action: 'change_service', service_id: newService })
                .done(function(res){
                    if(res && res.success){
                        location.reload();
                    } else {
                        alert(res.message || 'Error cambiando servicio');
                    }
                }).fail(function(xhr){
                    alert('Error en la petición: ' + (xhr.responseJSON?.message || xhr.responseText || xhr.statusText));
                });
        });
    })();
</script>