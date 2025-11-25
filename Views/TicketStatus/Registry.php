<div class="row">
        <div class="col-md-6">
            <div class="card-mb-grid">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-header-title"><h3>Información de Estado de Ticket</h3></div>
                </div>

                <div class="card-body collapse show">
                    <form action="" method="POST">
                        <input type="hidden" name="Registrar" id="Registrar" value="1">

                        <div class="form-group">
                            <input require type="text" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre del Estado</label>
                            <input placeholder="Ej: Abierto, Cerrado" type="text" name="name" id="name" class="form-control" value="<?php echo $JData->name; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="description" class="form-label">Descripción</label>
                            <input placeholder="Ej: Estado que indica que el ticket está abierto o cerrado" rows="4" type="text" name="description" id="description" class="form-control" value="<?php echo $JData->description; ?>">
                        </div> <br>

                        <div class="form-group">
                            <a href="/TicketStatus" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>