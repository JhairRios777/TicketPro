<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Estado de Ticket</h5>
                </div>
                <div class="card-body">
                    <form id="formRegistryTicketStatus" method="post">

                        <div class="mb-4">
                            <label for="inputTicketStatusName" class="form-label">Nombre del Estado de Ticket</label>
                            <input type="text" class="form-control" id="inputTicketStatusName" name="name" placeholder="Ej: Abierto, En Progreso, Cerrado" required>
                        </div>


                        <div class="mb-4">
                            <label for="inputDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="inputDescription" name="description" rows="4" placeholder="Describe las responsabilidades de este servicio"></textarea>
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