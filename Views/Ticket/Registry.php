<?php
    use Models\Service as Service;
    use Models\ClientType as ClientType;
    use Models\TicketStatus as Status;
    use Models\User as User;

    $services = new Service();
    $services = $services->toList();
    
    $clientTypes = new ClientType();
    $clientTypes = $clientTypes->toList();
    
    $statuses = new Status();
    $statuses = $statuses->toList();

    $users = new User();
    $users = $users->toList();
?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-grid">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-header-title"><h3>Información de Ticket</h3></div>
            </div>

            <div class="card-body collapse show">
                <form action="" method="POST">

                    <input type="hidden" name="Registrar" id="Registrar" value="1">

                    <div class="form-group">
                        <input require type="text" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="ticket_code" class="form-label">Código de Ticket</label>
                        <input type="text" name="ticket_code" id="ticket_code" class="form-control" value="<?php echo $JData->ticket_code; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="service_id" class="form-label">Servicio</label>
                        <select name="service_id" id="service_id"  class="form-select">
                            <?php
                                foreach($services as $key => $value) {
                                    $selected = ($JData->service_id == $service->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="client_type_id" class="form-label">Tipo de Cliente</label>
                        <select name="client_type_id" id="client_type_id" class="form-select">
                            <?php
                                foreach($clientTypes as $key => $value) {
                                    $selected = ($JData->client_type_id == $clientType->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="status_id" class="form-label">Estado</label>
                        <select name="status_id" id="status_id" class="form-select">
                            <?php
                                foreach($statuses as $key => $value) {
                                    $selected = ($JData->status_id == $status->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="user_id" class="form-label">Usuario</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <?php
                                foreach($users as $key => $value) {
                                    $selected = ($JData->user_id == $user->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <a href="/Ticket" class="btn btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>

                    

                </form>
            </div>
        </div>
    </div>
</div>