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