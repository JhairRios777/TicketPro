<?php
    use Models\User as User;
    use Models\ServiceDesk as ServiceDesk;
    use Models\Role as Role;
    use Models\Ticket as Ticket;
    use Config\Conexion as Conexion;

    $users = new User();
    $users = $users->toList();
    $services = new ServiceDesk();
    $services = $services->toList();
    $roles = new Role();
    $roles = $roles->toList();
    $ticket = new Ticket();
    $tickets = $ticket->toList();

    $userMap = [];
    foreach ($users as $u) {
        if (isset($u->id)) $userMap[$u->id] = $u->username;
    }
    $deskMap = [];
    foreach ($services as $s) {
        if (isset($s->id)) $deskMap[$s->id] = $s->desk_name;
    }
    $roleMap = [];
    foreach ($roles as $r) {
        if (isset($r->id)) $roleMap[$r->id] = $r->name;
    }
    $ticketMap = [];
    foreach ($tickets as $t) {
        if (isset($t->id)) $ticketMap[$t->id] = $t->id;
    }

   
?>

<h1>Auditoría</h1>

<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Auditorías</div>
       

</div>

    <div class="table-responsive-md">
        <table class="table table-actions table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Desk</th>
                    <th>Ticket</th>
                    <th>Acción</th>
                    <th>Detalles</th>
                    <th>Fecha/Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    $userName = isset($userMap[$Value->user_id]) ? $userMap[$Value->user_id] : (isset($Value->user_id) ? $Value->user_id : '');
                    $deskName = isset($deskMap[$Value->desk_id]) ? $deskMap[$Value->desk_id] : (isset($Value->desk_id) ? $Value->desk_id : '');
                    $ticketName = isset($ticketMap[$Value->ticket_id]) ? $ticketMap[$Value->ticket_id] : (isset($Value->ticket_id) ? $Value->ticket_id : '');
                    $date_time = isset($Value->date_time) ? $Value->date_time : '';
                    echo "<tr>";
                        echo "<td>".htmlspecialchars($Value->id)."</td>";

                        echo "<td>".htmlspecialchars($userName)."</td>";
                        echo "<td>".htmlspecialchars($deskName)."</td>";
                        echo "<td>".htmlspecialchars($ticketName)."</td>";
                        echo "<td>".htmlspecialchars($Value->action)."</td>";
                        echo "<td>".htmlspecialchars($Value->details)."</td>";
                        echo "<td>".htmlspecialchars($date_time)."</td>";
                        echo "<td>";
                                echo "<a href='Audit/View/".$Value->id."' class='btn btn-sm btn-primary'>Ver</a>";
                        echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
