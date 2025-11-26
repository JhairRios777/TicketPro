<div class="row">
        <div class="col-md-6">
            <div class="card-mb-grid">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-header-title"><h3>Registro de Tipo de Cliente</h3></div>
                </div>

                <div class="card-body collapse show">
                    <form id="clientTypeForm" action="" method="POST">
                        <input type="hidden" name="Registrar" id="Registrar" value="1">

                        <div class="form-group">
                            <input require type="hidden" name="id" id="id" class="form-control" readonly value="<?php echo $JData->id; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Nombre del Tipo de Cliente</label>
                            <input placeholder="Ej: Preferencial, General" type="text" name="name" id="name" class="form-control" value="<?php echo $JData->name; ?>">
                        </div> <br>
                        
                        <div class="form-group">
                            <label for="description" class="form-label">Descripción</label>
                            <input placeholder="Ej: Cliente preferencial, Cliente general" rows="4" type="text" name="description" id="description" class="form-control" value="<?php echo $JData->description; ?>">
                        </div> <br>

                        <div class="form-group">
                            <a href="/ClientType" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const form = document.getElementById('clientTypeForm');
    if (!form) return;

    form.addEventListener('submit', async function(e){
        e.preventDefault();

        // VALIDACIÓN CLIENTE: campos obligatorios
        const name = document.getElementById('name')?.value?.trim() || '';

        if (!name) {
            await Swal.fire('Error', 'El campo Nombre del Tipo de Cliente es obligatorio.', 'error');
            document.getElementById('name')?.focus();
            return;
        }

        const confirm = await Swal.fire({
            title: '¿Guardar cambios?',
            text: 'Se guardarán los datos del tipo de cliente.',
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
                const msg = data && data.message ? data.message : 'Tipo de cliente guardado correctamente.';
                await Swal.fire('Éxito', msg, 'success');
                window.location.href = (data && data.redirect) ? data.redirect : '/ClientType';
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