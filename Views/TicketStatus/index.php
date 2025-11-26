<h1>Estados de Tickets</h1> <br>
<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Estados de Tickets</div>

        <div class="pulleft">
            <a href='/TicketStatus/Registry/' type="button" class="btn btn-sm btn-primary">Crear Nuevo Estado de Ticket</a>
        </div>
    </div>

    <div class="table-responsive-md">
        <table class="table table-actions table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th width="20%">Nombre</th>
                    <th width="40%">Descripcion</th>
                    <th width="20%">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    echo "<tr>";
                        echo "<td>".$Value-> name."</td>";
                        echo "<td>".$Value-> description."</td>";
                        echo "<td>
                        <a href='/TicketStatus/Registry/".$Value->id."' class='btn btn-sm btn-primary'>Editar</a>
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

        var data = { id: id, table: 'ticketstatus'};

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