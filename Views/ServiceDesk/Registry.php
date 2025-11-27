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
                <form id="serviceDeskForm" action="" method="POST">

                    <input type="hidden" name="Registrar" id="Registrar" value="1">

                    <div class="form-group">
                        <input require type="hidden" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="desk_name" class="form-label">Nombre de la Estación</label>
                        <input autocomplete="off" type="text" name="desk_name" id="desk_name" class="form-control" placeholder="Nombre de la Estación" value="<?php echo $JData->desk_name; ?>">
                    </div> <br>

                    <div class="form-group">
                        <label for="user_id" class="form-label">Usuario asignado</label>
                        <select name="user_id" id="user_id"  class="form-select">
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
                        <label for="branch_id" class="form-label">Sucursal</label>
                        <select name="branch_id" id="branch_id" class="form-select">
                            <option value="" default="selected">-- SELECCIONE UNA OPCIÓN --</option>
                            <?php
                                foreach($branches as $key => $value) {
                                    $selected = ($JData->branch_id == $value->id) ? 'selected' : '';
                                    echo "<option value='".$value->id."' $selected>".$value->branch_name."</option>";
                                }
                            ?>
                        </select>
                    </div> <br>

                    <div class="form-group">
                        <a href="/ServiceDesk" class="btn btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                    

                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const form = document.getElementById('serviceDeskForm');
    if (!form) return;

    form.addEventListener('submit', async function(e){
        e.preventDefault();

        // VALIDACIÓN CLIENTE: campos obligatorios
        const desk_name = document.getElementById('desk_name')?.value?.trim() || '';
        const user_id = document.getElementById('user_id')?.value || '';
        const branch_id = document.getElementById('branch_id')?.value || '';

        if (!desk_name) {
            await Swal.fire('Error', 'El campo Nombre de la Estación es obligatorio.', 'error');
            document.getElementById('desk_name')?.focus();
            return;
        }
        if (!user_id) {
            await Swal.fire('Error', 'El campo Usuario asignado es obligatorio.', 'error');
            document.getElementById('user_id')?.focus();
            return;
        }
        if (!branch_id) {
            await Swal.fire('Error', 'El campo Sucursal es obligatorio.', 'error');
            document.getElementById('branch_id')?.focus();
            return;
        }

        const confirm = await Swal.fire({
            title: '¿Guardar cambios?',
            text: 'Se guardarán los datos de la Estación de Servicio.',
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
                const msg = data && data.message ? data.message : 'Estación de Servicio guardada correctamente.';
                await Swal.fire('Éxito', msg, 'success');
                window.location.href = (data && data.redirect) ? data.redirect : '/ServiceDesk';
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
