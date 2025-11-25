<div class="row">
        <div class="col-md-6">
            <div class="card-mb-grid">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-header-title"><h3>Registro de Sucursal</h3></div>
                </div>

                <div class="card-body collapse show">
                    <form action="" method="POST">

                        <input type="hidden" name="Registrar" id="Registrar" value="1">

                        <div class="form-group">
                            <input require type="text" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="branch_name" class="form-label">Nombre de la Sucursal</label>
                            <input placeholder="Ej: Sucursal Centro, Sucursal Norte" type="text" name="branch_name" id="branch_name" class="form-control" value="<?php echo $JData->branch_name; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Ubicación</label>
                            <input placeholder="Ej: Calle 123, San Pedro Sula" rows="4" type="text" name="location" id="location" class="form-control" value="<?php echo $JData->location; ?>">
                        </div> <br>

                        <div class="form-group">
                            <a href="/Branch" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>