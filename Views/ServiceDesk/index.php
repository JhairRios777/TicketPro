<?php
    use Models\User as User;
    use Models\Branch as Branch;

    $users = new User();
    $users = $users->toList();
    $branches = new Branch();
    $branches = $branches->toList();

    $userMap = [];
    foreach ($users as $u) {
        if (isset($u->id)) $userMap[$u->id] = $u->name;
    }
    $branchMap = [];
    foreach ($branches as $b) {
        if (isset($b->id)) $branchMap[$b->id] = $b->branch_name;
    }
?>

<h1>Estaciones de Servicio</h1>
<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Estaciones</div>

        <div class="pulleft">
            <a href='/ServiceDesk/Registry/' type="button" class="btn btn-sm btn-primary">Crear Nueva Estación</a>
        </div>
    </div>

    <div class="table-responsive-md">
        <table class="table table-actions table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Nombre de la Estación</th>
                    <th width="20%">Usuario</th>
                    <th>Sucursal</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    $userName = isset($userMap[$Value->user_id]) ? $userMap[$Value->user_id] : $Value->user_id;
                    $branchName = isset($branchMap[$Value->branch_id]) ? $branchMap[$Value->branch_id] : $Value->branch_id;

                    echo "<tr>";
                        echo "<td>".$Value-> desk_name."</td>";
                        echo "<td>".$userName."</td>";
                        echo "<td>".$branchName."</td>";
                        
                        echo "<td>
                        <a href='/ServiceDesk/Registry/".$Value->id."' class='btn btn-sm btn-primary'>Editar</a>
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

        var data = { id: id, table: 'servicedesk' };

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