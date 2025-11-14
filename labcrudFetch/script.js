// Cargar productos al iniciar
document.addEventListener('DOMContentLoaded', function() {
    listarProductos();
});

function listarProductos(busqueda = '') {
    const formData = new FormData();
    formData.append('Accion', 'Listar');
    formData.append('busqueda', busqueda);

    fetch('registrar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        let html = '';
        data.forEach(producto => {
            html += `
                <tr>
                    <td>${producto.id}</td>
                    <td>${producto.codigo}</td>
                    <td>${producto.producto}</td>
                    <td>$${producto.precio}</td>
                    <td>${producto.cantidad}</td>
                    <td>
                        <button type='button' class='btn btn-success btn-sm' onclick='editarProducto(${producto.id})'>Editar</button>
                        <button type='button' class='btn btn-danger btn-sm' onclick='eliminarProducto(${producto.id})'>Eliminar</button>
                    </td>        
                </tr>`;
        });
        document.getElementById('resultado').innerHTML = html;
    })
    .catch(error => console.error('Error:', error));
}

function procesarFormulario() {
    limpiarErrores();
    
    const formData = new FormData(document.getElementById('frm'));
    const accion = document.getElementById('Accion').value;

    fetch('registrar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        switch(data.accion) {
            case 'Guardar':
            case 'Modificar':
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    resetForm();
                    listarProductos();
                } else {
                    mostrarErrores(data.errors);
                    Swal.fire({
                        icon: 'error',
                        title: data.message,
                        text: 'Verifique los campos marcados'
                    });
                }
                break;
                
            case 'Eliminar':
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    listarProductos();
                }
                break;
                
            default:
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Acción no reconocida'
                });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo completar la operación'
        });
    });
}

function editarProducto(id) {
    const formData = new FormData();
    formData.append('Accion', 'Obtener');
    formData.append('id', id);

    fetch('registrar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('idp').value = data.id;
        document.getElementById('codigo').value = data.codigo;
        document.getElementById('producto').value = data.producto;
        document.getElementById('precio').value = data.precio;
        document.getElementById('cantidad').value = data.cantidad;
        document.getElementById('Accion').value = 'Modificar';
        document.getElementById('btnAccion').textContent = 'Actualizar';
        
        // Scroll to form
        document.querySelector('.card').scrollIntoView({ behavior: 'smooth' });
    })
    .catch(error => console.error('Error:', error));
}

function eliminarProducto(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('Accion', 'Eliminar');
            formData.append('id', id);

            fetch('registrar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: 'Producto eliminado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    listarProductos();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
}

function buscarProductos() {
    const valor = document.getElementById('buscar').value;
    listarProductos(valor);
}

function resetForm() {
    document.getElementById('frm').reset();
    document.getElementById('Accion').value = 'Guardar';
    document.getElementById('btnAccion').textContent = 'Registrar';
    document.getElementById('idp').value = '';
    limpiarErrores();
}

function limpiarErrores() {
    const errorElements = document.querySelectorAll('.text-danger');
    errorElements.forEach(element => {
        element.textContent = '';
    });
}

function mostrarErrores(errors) {
    limpiarErrores();
    if (errors) {
        for (const [field, message] of Object.entries(errors)) {
            const errorElement = document.getElementById(`error-${field}`);
            if (errorElement) {
                errorElement.textContent = message;
            }
        }
    }
}