<?php
    use Models\User as User;
    use Models\ServiceDesk as ServiceDesk;
    use Models\Role as Role;
    use Models\Ticket as Ticket;
    use Config\Conexion as Conexion;

    $users = new User();
    $users = $users->toList();
    $services = new ServiceDesk();
    $services = $services->toList();
    $roles = new Role();
    $roles = $roles->toList();
    $ticket = new Ticket();
    $tickets = $ticket->toList();

    // Ensure $JData is populated when the route is /Audit/Registry/{id}
    if ((!isset($JData) || empty($JData->id))) {
        if (isset($_GET['url'])) {
            $parts = explode('/', trim($_GET['url'], '/'));
            $parts = array_values(array_filter($parts));
            if (isset($parts[0]) && strtolower($parts[0]) === 'audit' && isset($parts[1]) && strtolower($parts[1]) === 'registry' && isset($parts[2]) && $parts[2] !== '') {
                $reqId = $parts[2];
                try {
                    $auditModel = new \Models\Audit();
                    $found = $auditModel->getForId($reqId);
                    if ($found) {
                        $JData = $found;
                    }
                } catch (Exception $e) {
                    // ignore
                }
            }
        }
    }

    // Ensure $JData exists to avoid notices
    if (!isset($JData) || !is_object($JData)) {
        $JData = new stdClass();
        $JData->id = '';
        $JData->user_id = '';
        $JData->desk_id = '';
        $JData->ticket_id = '';
        $JData->action = '';
        $JData->details = '';
        $JData->date_time = '';
    }

?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-grid">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-header-title"><h3>Registro de Auditoría</h3></div>
            </div>

            <div class="card-body collapse show">
                <form action="" method="POST">

                    <input type="hidden" name="Registrar" id="Registrar" value="1">

                    <div class="form-group">
                        <input require type="text" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="user_id" class="form-label">Usuario</label>
                        <select name="user_id" id="user_id"  class="form-select">
                            <?php
                                foreach($users as $key => $value) {
                                    $selected = ($JData->user_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->username."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>
                    <div class="form-group">
                        <label for="desk_id" class="form-label">Desk</label>
                        <select name="desk_id" id="desk_id"  class="form-select">
                            <?php
                                foreach($services as $key => $value) {
                                    $selected = ($JData->desk_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->desk_name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>
                    
                    <div class="form-group">
                        <label for="ticket_id" class="form-label">Ticket</label>
                        <select name="ticket_id" id="ticket_id" class="form-select">
                            <?php
                                foreach($tickets as $key => $value) {
                                    $selected = ($JData->ticket_id == $value->id) ? 'selected' : '';
                                    $label = (isset($value->subject) && $value->subject !== '') ? $value->subject : (isset($value->ticket_code) ? $value->ticket_code : $value->id);
                                    echo "<option value='".$value->id."' $selected>".htmlspecialchars($label)."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>
                    <div class="form-group">
                        <label for="action" class="form-label">Acción</label>
                        <input type="text" name="action" id="action" class="form-control" value="<?php echo $JData->action; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="details" class="form-label">Detalles</label>
                        <textarea name="details" id="details" class="form-control" rows="4"><?php echo $JData->details; ?></textarea>
                    </div> <br>

                    <div class="form-group">
                        <label for="date_time" class="form-label">Fecha/Hora</label>
                        <input type="datetime-local" name="date_time" id="date_time" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($JData->date_time)); ?>">
                    </div> <br>

                    <div class="form-group">
                        <a href="/Audit" class="btn btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
