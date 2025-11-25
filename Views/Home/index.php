
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
                    <span class="badge bg-success">En línea</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <!-- Tickets Totales -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-stat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-2">Tickets Totales</h6>
                            <h3 class="mb-0">1,245</h3>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 12% este mes</small>
                        </div>
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Abiertos -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-stat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-2">Abiertos</h6>
                            <h3 class="mb-0">342</h3>
                            <small class="text-warning"><i class="fas fa-hourglass-half"></i> Pendientes</small>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Resueltos -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-stat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-2">Resueltos</h6>
                            <h3 class="mb-0">892</h3>
                            <small class="text-success"><i class="fas fa-check-circle"></i> Completados</small>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usuarios Activos -->
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card card-stat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted mb-2">Sin Respuesta </h6>
                            <h3 class="mb-0">58</h3>
                            <small class="text-info"><i class="fas fa-user-slash"></i> Conectados</small>
                        </div>
                        <div class="stat-icon bg-info">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row">
        <!-- Tablas de Tickets por categoría (muestra ticket y caja que los atiende) -->
        <div class="col-12 mb-4">
            <?php
                // Datos estáticos de ejemplo (sin BD): cada elemento tiene id y caja
                $normalTickets = [
                    ['id' => '1256', 'caja' => 'Caja 1'],
                    ['id' => '1254', 'caja' => 'Caja 2'],
                    ['id' => '1252', 'caja' => 'Caja 3']
                ];

                $customerTickets = [
                    ['id' => '1255', 'caja' => 'Caja A'],
                    ['id' => '1251', 'caja' => 'Caja B']
                ];

                $premiumTickets = [
                    ['id' => '1250', 'caja' => 'Caja P1'],
                    ['id' => '1248', 'caja' => 'Caja P2']
                ];
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
                                            <th>#Ticket</th>
                                            <th>Caja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($normalTickets as $tk){ ?>
                                            <tr>
                                                <td><strong>#<?php echo $tk['id']; ?></strong></td>
                                                <td><?php echo $tk['caja']; ?></td>
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
                                            <th>#Ticket</th>
                                            <th>Caja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($customerTickets as $tk){ ?>
                                            <tr>
                                                <td><strong>#<?php echo $tk['id']; ?></strong></td>
                                                <td><?php echo $tk['caja']; ?></td>
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
                                            <th>#Ticket</th>
                                            <th>Caja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($premiumTickets as $tk){ ?>
                                            <tr>
                                                <td><strong>#<?php echo $tk['id']; ?></strong></td>
                                                <td><?php echo $tk['caja']; ?></td>
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