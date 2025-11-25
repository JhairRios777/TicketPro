<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información de la Estación</h5>
                </div>
                <div class="card-body">
                    <form id="formRegistryServiceDesk" method="post">

                        <div class="mb-4">
                            <label for="inputServiceName" class="form-label">Nombre de la Estación</label>
                            <input type="text" class="form-control" id="inputServiceName" name="name" placeholder="Caja, Preferencial, Atención al Cliente" required>
                        </div>

                        <div class="mb-4">
                            <label for="inputServiceName" class="form-label">Sucursal</label>
                            <input type="text" class="form-control" id="inputServiceName" name="name" placeholder="Ej: Santa Barbara, San Pedro, Tegus" required>
                        </div>

                        <div class="mb-4">
                            <label for="inputServiceName" class="form-label">Nombre de la Estación</label>
                            <input type="text" class="form-control" id="inputServiceName" name="name" placeholder="Ej: caja, Preferenccial, Atencion al Cliente" required>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="/Role" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>