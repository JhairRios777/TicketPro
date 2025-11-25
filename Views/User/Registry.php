<?php
    use Models\Service as Service;
    use Models\Role as Role;

    $services = new Service();
    $services = $services->toList();

    $roles = new Role();
    $roles = $roles->toList();
    //echo json_encode($roles);
?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-grid">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-header-title"><h3>Registro de Usuario</h3></div>
            </div>

            <div class="card-body collapse show">
                <form action="" method="POST">

                    <input type="hidden" name="Registrar" id="Registrar" value="1">

                    <div class="form-group">
                        <input require type="hidden" name="Id" id="Id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                    </div>

                    <div class="form-group">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?php echo $JData->username; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo $JData->password; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="name" class="form-label">Nombre Completo</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $JData->name; ?>">
                    </div> <br>


                    <div class="form-group">
                        <label for="email" class="form-label">Correo</label>
                        <input type="text" name="email" id="email" class="form-control" value="<?php echo $JData->email; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $JData->phone; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="service_id" class="form-label">Servicio</label>
                        <select name="service_id" id="service_id"  class="form-select">
                            <?php
                                foreach($services as $key => $value) {
                                    $selected = ($JData->service_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="role_id" class="form-label">Rol</label>
                        <select name="role_id" id="role_id" class="form-select">
                            <?php
                                foreach($roles as $key => $value) {
                                    $selected = ($JData->role_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="status" class="form-label">Estado</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Active" <?php if($JData->status == 'Active'){ echo "selected"; } ?>>Activo</option>
                            <option value="Inactive" <?php if($JData->status == 'Inactive'){ echo "selected"; } ?>>Inactivo</option>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <a href="/User" class="btn btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>

                    

                </form>
            </div>
        </div>
    </div>
</div>