<?php
    use Models\User as User;
    use Models\Branch as Branch;

    $users = new User();
    $users = $users->toList();

    $branches = new Branch();
    $branches = $branches->toList();
    //echo json_encode($branches);
?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-grid">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-header-title"><h3>Información de la Estación</h3></div>
            </div>

            <div class="card-body collapse show">
                <form action="" method="POST">

                    <input type="hidden" name="Registrar" id="Registrar" value="1">

                    <div class="form-group">
                        <input require type="text" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="desk_name" class="form-label">Nombre de la Estación</label>
                        <input type="text" name="desk_name" id="desk_name" class="form-control" placeholder="Nombre de la Estación" value="<?php echo $JData->desk_name; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="user_id" class="form-label">Usuario asignado</label>
                        <select name="user_id" id="user_id"  class="form-select">
                            <?php
                                foreach($users as $key => $value) {
                                    $selected = ($JData->user_id == $user->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="branch_id" class="form-label">Sucursal</label>
                        <select name="branch_id" id="branch_id" class="form-select">
                            <?php
                                foreach($branches as $key => $value) {
                                    $selected = ($JData->branch_id == $branch->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->branch_name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <a href="/ServiceDesk" class="btn btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>

                    

                </form>
            </div>
        </div>
    </div>
</div>
