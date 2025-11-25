<h1>Servicios</h1> <br>
<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Servicios</div>

        <div class="pulleft">
            <a href='/Service/Registry/' type="button" class="btn btn-sm btn-primary">Crear Nuevo Servicio</a>
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
                        <a href='/Service/Registry/".$Value->id."' class='btn btn-sm btn-primary'>Editar</a>
                        <a href='javascript:eliminar(".$Value->id.");' class='btn btn-sm btn-secondary'>Eliminar</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>