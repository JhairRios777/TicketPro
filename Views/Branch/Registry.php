<div class="row">
        <div class="col-md-6">
            <div class="card-mb-grid">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-header-title"><h3>Registro de Sucursal</h3></div>
                </div>

                <div class="card-body collapse show">
                    <form id="branchForm" action="" method="POST">

                        <input type="hidden" name="Registrar" id="Registrar" value="1">

                        <div class="form-group">
                            <input require type="hidden" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="branch_name" class="form-label">Nombre de la Sucursal</label>
                            <input autocomplete="off" placeholder="Ej: Sucursal Centro, Sucursal Norte" type="text" name="branch_name" id="branch_name" class="form-control" value="<?php echo $JData->branch_name; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="location" class="form-label">Ubicación</label>
                            <input autocomplete="off" placeholder="Ej: Calle 123, San Pedro Sula" rows="4" type="text" name="location" id="location" class="form-control" value="<?php echo $JData->location; ?>">
                        </div> <br>

                        <div class="form-group">
                            <a href="/Branch" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const form = document.getElementById('branchForm');
    if (!form) return;

    form.addEventListener('submit', async function(e){
        e.preventDefault();

        // VALIDACIÓN CLIENTE: campos obligatorios
        const branch_name = document.getElementById('branch_name')?.value?.trim() || '';
        const location = document.getElementById('location')?.value?.trim() || '';

        if (!branch_name) {
            await Swal.fire('Error', 'El campo Nombre de la Sucursal es obligatorio.', 'error');
            document.getElementById('branch_name')?.focus();
            return;
        }
        if (!location) {
            await Swal.fire('Error', 'El campo Ubicación es obligatorio.', 'error');
            document.getElementById('location')?.focus();
            return;
        }

        const confirm = await Swal.fire({
            title: '¿Guardar cambios?',
            text: 'Se guardarán los datos de la sucursal.',
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
                const msg = data && data.message ? data.message : 'Sucursal guardada correctamente.';
                await Swal.fire('Éxito', msg, 'success');
                window.location.href = (data && data.redirect) ? data.redirect : '/Branch';
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