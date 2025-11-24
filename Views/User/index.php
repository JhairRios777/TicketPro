<?php
    use Models\Service as Service;
    use Models\Role as Role;

    $services = new Service();
    $services = $services->toList();

    $roles = new Role();
    $roles = $roles->toList();
    
    $serviceMap = [];
    foreach ($services as $s) {
        if (isset($s->id)) $serviceMap[$s->id] = $s->name;
    }
    $roleMap = [];
    foreach ($roles as $r) {
        if (isset($r->id)) $roleMap[$r->id] = $r->name;
    }
?>

<h1>Usuarios</h1>

<div class="card mb-grid">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="card-header-title">Lista de Usuarios</div>

        <div class="pulleft">
            <!-- <a href='/User/Registry/' type="button" class="btn btn-sm btn-primary">Registrar Usuario</a>
         -->
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistryUser">
                Registrar Usuario
            </button>
        </div>
    </div>

    <div class="table-responsive-md">
        <table class="table table-actions table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th width="12%">Usuario</th>
                    <th>Nombre Completo</th>
                    <th width="15%">Correo</th>
                    <th width="10%">Teléfono</th>
                    <th width="15%">Servicio</th>
                    <th width="12%">Rol</th>
                    <th width="10%">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    $serviceName = isset($serviceMap[$Value->service_id]) ? $serviceMap[$Value->service_id] : $Value->service_id;
                    $roleName = isset($roleMap[$Value->role_id]) ? $roleMap[$Value->role_id] : $Value->role_id;

                    echo "<tr>";
                        echo "<td>".$Value-> username."</td>";
                        echo "<td>".$Value-> name."</td>";
                        echo "<td>".$Value-> email."</td>";
                        echo "<td>".$Value-> phone."</td>";
                        echo "<td>".htmlspecialchars($serviceName)."</td>";
                        echo "<td>".htmlspecialchars($roleName)."</td>";
                        echo "<td>".$Value-> status."</td>";
                        echo "<td>
                        <a type='button' data-bs-toggle=\"modal\" data-bs-target=\"#modalRegistryUser\" href='/User/Registry/".$Value->id."' class='btn btn-sm btn-primary'>Editar</a>
                        <a href='javascript:eliminar(".$Value->id.");' class='btn btn-sm btn-secondary'>Eliminar</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRegistryUser" tabindex="-1" aria-labelledby="modalRegistryUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRegistryUserLabel">Registrar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRegistryUser">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre Completo" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="mail@example.com" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="9999-9999" required>
            </div>
            <div class="mb-3">
                <label for="service_id" class="form-label">Servicio</label>
                <select name="service_id" class="form-control form-select" id="service_id">
                    <?php
                        $currentServiceId = isset($JData->service_id) ? $JData->service_id : null;
                        foreach($services as $key => $service) {
                            $selected = ($currentServiceId == $service->id) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($service->id)."' $selected>".htmlspecialchars($service->name)."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select name="role_id" class="form-control form-select" id="role_id">
                    <?php
                        $currentRoleId = isset($JData->role_id) ? $JData->role_id : null;
                        foreach($roles as $key => $role) {
                            $selected = ($currentRoleId == $role->id) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($role->id)."' $selected>".htmlspecialchars($role->name)."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Estado</label>
                <select name="status" id="status" class="form-control form-select" required>
                    <option value="Active">Activo</option>
                    <option value="Inactive">Inactivo</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>