<?php
    use Models\Service as Service;
    use Models\Role as Role;

    $services = new Service();
    $services = $services->toList();

    $roles = new Role();
    $roles = $roles->toList();
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
                    <th width="10%">Usuario</th>
                    <th>Nombre Completo</th>
                    <th width="15%">Correo</th>
                    <th width="10%">Teléfono</th>
                    <th width="20%">Servicio</th>
                    <th width="10%">Rol</th>
                    <th width="10%">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($JData as $Key => $Value)
                {
                    echo "<tr>";
                        echo "<td>".$Value-> username."</td>";
                        echo "<td>".$Value-> name."</td>";
                        echo "<td>".$Value-> email."</td>";
                        echo "<td>".$Value-> phone."</td>";
                        echo "<td>".$Value-> service_id."</td>";
                        echo "<td>".$Value-> role_id."</td>";
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
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="service_id" class="form-label">Servicio</label>
                <select name="service_id" class="form-control" id="service_id">
                    <?php
                        foreach($services as $key => $value) {
                            $selected = ($JData->service_id == $service->id) ? 'selected' : '';
                            echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select name="role_id" class="form-control" id="role_id">
                    <?php
                        foreach($roles as $key => $value) {
                            $selected = ($JData->role_id == $role->id) ? 'selected' : '';
                            echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Estado</label>
                <select name="status" id="status" class="form-control" required>
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