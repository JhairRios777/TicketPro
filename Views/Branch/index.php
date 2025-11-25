<h1>Sucursales</h1>
<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Sucursales</div>

        <div class="pulleft">
            <a href='/Branch/Registry/' type="button" class="btn btn-sm btn-primary">Crear Nueva Sucursal</a>
        </div>
    </div>

    <div class="table-responsive-md">
        <table class="table table-actions table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th width="30%">Nombre</th>
                    <th>Ubicación</th>
                    <th width="15%">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    echo "<tr>";
                        echo "<td>".$Value-> branch_name."</td>";
                        echo "<td>".$Value-> location."</td>";
                        echo "<td>
                        <a href='/Branch/Registry/".$Value->id."' class='btn btn-sm btn-primary'>Editar</a>
                        <a href='javascript:eliminar(".$Value->id.");' class='btn btn-sm btn-secondary'>Eliminar</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>