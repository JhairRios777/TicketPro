<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información de la Sucursal</h5>
                </div>
                <div class="card-body">
                    <form id="formRegistryBranch" method="post">

                        <div class="mb-4">
                            <label for="inputBranchName" class="form-label">Nombre de la Sucursal</label>
                            <input type="text" class="form-control" id="inputBranchName" name="name" placeholder="Ej: Sucursal Centro, Sucursal Norte" required>
                        </div>


                        <div class="mb-4">
                            <label for="inputDescription" class="form-label">Ubicación</label>
                            <textarea class="form-control" id="inputDescription" name="description" rows="4" placeholder="Describe la ubicación de esta sucursal"></textarea>
                        </div>


                        <div class="d-flex gap-2 justify-content-end">
                            <a href="/Branch" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Sucursal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>