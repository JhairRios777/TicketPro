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
                <form id="ticketForm" action="" method="POST">

                    <input type="hidden" name="Registrar" id="Registrar" value="1">

                    <div class="form-group">
                        <input require type="hidden" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="ticket_code" class="form-label">Código de Ticket</label>
                        <input type="text" name="ticket_code" id="ticket_code" class="form-control" value="<?php echo $JData->ticket_code; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="service_id" class="form-label">Servicio</label>
                        <select name="service_id" id="service_id"  class="form-select">
                            <option value="" default="selected">-- SELECCIONE UNA OPCIÓN --</option>
                            <?php
                                foreach($services as $key => $value) {
                                    $selected = ($JData->service_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="client_type_id" class="form-label">Tipo de Cliente</label>
                        <select name="client_type_id" id="client_type_id" class="form-select">
                            <option value="" default="selected">-- SELECCIONE UNA OPCIÓN --</option>
                            <?php
                                foreach($clientTypes as $key => $value) {
                                    $selected = ($JData->client_type_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="status_id" class="form-label">Estado</label>
                        <select name="status_id" id="status_id" class="form-select">
                            <option value="" default="selected">-- SELECCIONE UNA OPCIÓN --</option>
                            <?php
                                foreach($statuses as $key => $value) {
                                    $selected = ($JData->status_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <label for="user_id" class="form-label">Usuario</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="" default="selected">-- SELECCIONE UNA OPCIÓN --</option>
                            <?php
                                foreach($users as $key => $value) {
                                    $selected = ($JData->user_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <a href="/Ticket" class="btn btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                    

                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const form = document.getElementById('ticketForm');
    if (!form) return;

    form.addEventListener('submit', async function(e){
        e.preventDefault();

        // VALIDACIÓN CLIENTE: campos obligatorios
        const ticket_code = document.getElementById('ticket_code')?.value?.trim() || '';
        const service_id = document.getElementById('service_id')?.value || '';
        const client_type_id = document.getElementById('client_type_id')?.value || '';
        const status_id = document.getElementById('status_id')?.value || '';
        const user_id = document.getElementById('user_id')?.value || '';

        if (!ticket_code) {
            await Swal.fire('Error', 'El campo Código del Ticket es obligatorio.', 'error');
            document.getElementById('ticket_code')?.focus();
            return;
        }
        if (!service_id) {
            await Swal.fire('Error', 'El campo Servicio es obligatorio.', 'error');
            document.getElementById('service_id')?.focus();
            return;
        }
        if (!client_type_id) {
            await Swal.fire('Error', 'El campo Tipo de Cliente es obligatorio.', 'error');
            document.getElementById('client_type_id')?.focus();
            return;
        }
        if (!status_id) {
            await Swal.fire('Error', 'El campo Estado es obligatorio.', 'error');
            document.getElementById('status_id')?.focus();
            return;
        }
        if (!user_id) {
            await Swal.fire('Error', 'El campo Usuario es obligatorio.', 'error');
            document.getElementById('user_id')?.focus();
            return;
        }

        const confirm = await Swal.fire({
            title: '¿Guardar cambios?',
            text: 'Se guardarán los datos del ticket.',
            icon: 'question',
            confirmButtonColor: "#b70124",
            cancelButtonColor: "#5c636a",
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        });
        if (!confirm.isConfirmed) return;

        const fd = new FormData(form);
        fd.append('ajax', '1');

        try {
            const res = await fetch(form.action || window.location.pathname, {
                method: 'POST',
                body: fd,
                credentials: 'same-origin'
            });

            const text = await res.text();
            let data = null;
            try { data = JSON.parse(text); } catch(e){ /* no JSON */ }

            if (res.ok) {
                const msg = data && data.message ? data.message : 'Ticket guardado correctamente.';
                await Swal.fire('Éxito', msg, 'success');
                window.location.href = (data && data.redirect) ? data.redirect : '/Ticket';
            } else {
                const errMsg = (data && data.message) ? data.message : (text || 'Error en el servidor');
                Swal.fire('Error', errMsg, 'error');
            }
        } catch (err) {
            console.error('Fetch error:', err);
            Swal.fire('Error', 'Error en la petición. Revisa la consola.', 'error');
        }
    });
})();
</script>