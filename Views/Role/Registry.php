<div class="row">
        <div class="col-md-6">
            <div class="card-mb-grid">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-header-title"><h3>Información de Rol</h3></div>
                </div>

                <div class="card-body collapse show">
                    <form action="" method="POST">
                        <input type="hidden" name="Registrar" id="Registrar" value="1">

                        <div class="form-group">
                            <input require type="text" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre del Rol</label>
                            <input placeholder="Ej: Administrador, Empleado" type="text" name="name" id="name" class="form-control" value="<?php echo $JData->name; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="description" class="form-label">Descripción</label>
                            <input placeholder="Ej: Rol con permisos administrativos" rows="4" type="text" name="description" id="description" class="form-control" value="<?php echo $JData->description; ?>">
                        </div> <br>

                        <div class="form-group">
                            <a href="/Role" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>