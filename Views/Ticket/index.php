<?php
    use Models\Service as Service;
    use Models\ClientType as ClientType;
    use Models\TicketStatus as Status;
    use Models\User as User;

    $services = new Service();
    $services = $services->toList();
    
    $clientTypes = new ClientType();
    $clientTypes = $clientTypes->toList();
    
    $statuses = new Status();
    $statuses = $statuses->toList();

    $users = new User();
    $users = $users->toList();

    $serviceMap = [];
    foreach ($services as $s) {
        if (isset($s->id)) $serviceMap[$s->id] = $s->name;
    }
    $clientTypeMap = [];
    foreach ($clientTypes as $ct) {
        if (isset($ct->id)) $clientTypeMap[$ct->id] = $ct->name;
    }
    $statusMap = [];
    foreach ($statuses as $st) {
        if (isset($st->id)) $statusMap[$st->id] = $st->name;
    }
    $userMap = [];
    foreach ($users as $u) {
        if (isset($u->id)) $userMap[$u->id] = $u->name;
    }
?>

<h1>Tickets</h1>

<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Tickets</div>

        <div class="pulleft">
            <a href='/Ticket/Registry/' type="button" class="btn btn-sm btn-primary">Registrar Ticket</a>
        </div>
    </div>

    <div class="table-responsive-md">
        <table class="table table-actions table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th width="10%">Código de Ticket</th>
                    <th width="15%">Servicio</th>
                    <th width="10%">Tipo de Cliente</th>
                    <th width="10%">Estado del Ticket</th>
                    <th width="10%">Usuario</th>
                    <th width="20%">Fecha y Hora de Creación</th>
                    <th width="15%">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    $serviceName = isset($serviceMap[$Value->service_id]) ? $serviceMap[$Value->service_id] : $Value->service_id;
                    
                    $clientTypeName = isset($clientTypeMap[$Value->client_type_id]) ? $clientTypeMap[$Value->client_type_id] : $Value->client_type_id;
                    
                    $statusName = isset($statusMap[$Value->status_id]) ? $statusMap[$Value->status_id] : $Value->status_id;
                    
                    $userName = isset($userMap[$Value->user_id]) ? $userMap[$Value->user_id] : $Value->user_id;

                    echo "<tr>";
                        echo "<td>".$Value-> ticket_code."</td>";
                        echo "<td>".htmlspecialchars($serviceName)."</td>";
                        echo "<td>".htmlspecialchars($clientTypeName)."</td>";
                        echo "<td>";
                            if($Value-> status_id == '1'){
                                echo '<span class="badge bg-success">'.htmlspecialchars($statusName).'</span>';
                            } else if($Value-> status_id == '2'){
                                echo '<span class="badge bg-danger">'.htmlspecialchars($statusName).'</span>';
                            } else if($Value-> status_id == '3'){
                                echo '<span class="badge bg-warning">'.htmlspecialchars($statusName).'</span>';
                            } else if($Value-> status_id == '4'){
                                echo '<span class="badge bg-secondary">'.htmlspecialchars($statusName).'</span>';
                            } 
                        echo "</td>";
                        echo "<td>".htmlspecialchars($userName)."</td>";
                        echo "<td>".htmlspecialchars($Value->date_time)."</td>";
                        
                        echo "<td>
                        <a href='/Ticket/Registry/".$Value->id."' class='btn btn-sm btn-primary'>Editar</a>
                        <a href='javascript:eliminar(".$Value->id.");' class='btn btn-sm btn-secondary'>Eliminar</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
   function eliminar(id) {
    Swal.fire({
        title: "¿Está seguro?",
        text: "¡No podrá revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#b70124",
        cancelButtonColor: "#5c636a",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (!result.isConfirmed) return;

        var data = { id: id, table: 'ticket' };

        $.ajax({
            url: "/API?method=Delete",
            method: "POST",
            data: data,
            dataType: "json"
        }).done(function(res) {
            if (res && res.success) {
                Swal.fire("Eliminado", res.message || "Registro eliminado correctamente.", "success")
                    .then(() => location.reload());
            } else {
                Swal.fire("Error", res?.message || "Error al eliminar el registro.", "error");
            }
        }).fail(function(xhr) {
            console.error("API error:", xhr);
            const msg = xhr.responseJSON?.message || xhr.responseText || "Error en la petición";
            Swal.fire("Error", msg, "error");
        });
    });
}
</script>