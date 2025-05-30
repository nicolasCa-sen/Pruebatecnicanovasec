window.addEventListener("load", function () {
    document.querySelectorAll('.estado-select').forEach(select => {
        select.addEventListener('change', function () {
            const id = this.dataset.id;
            const id_estado = this.value;

            fetch('index.php?entity=hallazgo&action=updateEstado', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${id}&id_estado=${id_estado}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Estado actualizado con éxito");
                } else {
                    alert("Error al actualizar estado");
                }
            })
            .catch(() => alert("Error en la solicitud"));
        });
    });
});
