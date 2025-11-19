<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Productos - Musical Instruments</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        .btn {
            padding: 8px 16px;
            border: 1px solid #ccc;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            background: #fff;
            color: #333;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-success {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
            border-color: #ffc107;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .header-actions {
            margin-bottom: 20px;
        }

        .header-actions .btn {
            margin-right: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #ddd;
            width: 90%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            margin-top: 15px;
        }

        .form-actions .btn {
            margin-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .actions .btn {
            padding: 5px 10px;
            font-size: 12px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid;
            display: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .precio {
            font-weight: bold;
            color: #28a745;
        }

        .stock {
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .stock-alto {
            background-color: #d4edda;
            color: #155724;
        }

        .stock-medio {
            background-color: #fff3cd;
            color: #856404;
        }

        .stock-bajo {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel de Productos</h1>
        <p class="subtitle">Gestiona el inventario de Musical Instruments</p>

        <div id="alert-container"></div>

        <div class="header-actions">
            <button class="btn btn-primary" onclick="abrirModalCrear()">Nuevo Producto</button>
            <button class="btn btn-secondary" onclick="cargarProductos()">Actualizar</button>
            <a href="productos.html" class="btn btn-secondary">Volver a Productos</a>
        </div>

        <div id="tabla-container">
            <table id="tabla-productos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-productos">
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">
                            Cargando productos...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Crear/Editar -->
    <div id="modal-producto" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2 id="modal-titulo">Nuevo Producto</h2>
            <form id="form-producto">
                <input type="hidden" id="producto-id" name="id">
                
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion"></textarea>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría *</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="Cuerdas">Cuerdas</option>
                        <option value="Vientos">Vientos</option>
                        <option value="Percusión">Percusión</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="precio">Precio *</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" value="0">
                </div>

                <div class="form-group">
                    <label for="imagen">Ruta de Imagen</label>
                    <input type="text" id="imagen" name="imagen" placeholder="ej: img/producto.jpg">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let productos = [];

        // Cargar productos al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarProductos();
        });

        // Cargar lista de productos
        async function cargarProductos() {
            try {
                const response = await fetch('../crud/listar.php');
                const data = await response.json();

                if (data.success) {
                    productos = data.data;
                    mostrarProductos(productos);
                } else {
                    mostrarAlerta('Error al cargar productos', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarAlerta('Error de conexión', 'error');
            }
        }

        // Mostrar productos en la tabla
        function mostrarProductos(productos) {
            const tbody = document.getElementById('tbody-productos');
            
            if (productos.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px;">No hay productos registrados</td></tr>';
                return;
            }

            tbody.innerHTML = productos.map(producto => {
                const stockClass = producto.stock > 10 ? 'stock-alto' : 
                                  producto.stock > 5 ? 'stock-medio' : 'stock-bajo';
                
                return `
                    <tr>
                        <td>${producto.id}</td>
                        <td><strong>${producto.nombre}</strong></td>
                        <td>${producto.categoria}</td>
                        <td class="precio">$${parseFloat(producto.precio).toLocaleString('es-AR', {minimumFractionDigits: 2})}</td>
                        <td><span class="stock ${stockClass}">${producto.stock}</span></td>
                        <td>${producto.fecha_creacion}</td>
                        <td class="actions">
                            <button class="btn btn-warning" onclick="editarProducto(${producto.id})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarProducto(${producto.id}, '${producto.nombre.replace(/'/g, "\\'")}')">Eliminar</button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Abrir modal para crear
        function abrirModalCrear() {
            document.getElementById('modal-titulo').textContent = 'Nuevo Producto';
            document.getElementById('form-producto').reset();
            document.getElementById('producto-id').value = '';
            document.getElementById('modal-producto').style.display = 'block';
        }

        // Editar producto
        function editarProducto(id) {
            const producto = productos.find(p => p.id == id);
            if (!producto) {
                mostrarAlerta('Producto no encontrado', 'error');
                return;
            }

            document.getElementById('modal-titulo').textContent = 'Editar Producto';
            document.getElementById('producto-id').value = producto.id;
            document.getElementById('nombre').value = producto.nombre;
            document.getElementById('descripcion').value = producto.descripcion || '';
            document.getElementById('categoria').value = producto.categoria;
            document.getElementById('precio').value = producto.precio;
            document.getElementById('stock').value = producto.stock;
            document.getElementById('imagen').value = producto.imagen || '';
            document.getElementById('modal-producto').style.display = 'block';
        }

        // Cerrar modal
        function cerrarModal() {
            document.getElementById('modal-producto').style.display = 'none';
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('modal-producto');
            if (event.target == modal) {
                cerrarModal();
            }
        }

        // Enviar formulario
        document.getElementById('form-producto').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = formData.get('id');
            const url = id ? '../crud/editar.php' : '../crud/crear.php';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    cerrarModal();
                    cargarProductos();
                } else {
                    mostrarAlerta(data.message || 'Error al guardar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarAlerta('Error de conexión', 'error');
            }
        });

        // Eliminar producto
        async function eliminarProducto(id, nombre) {
            if (!confirm(`¿Estás seguro de eliminar el producto "${nombre}"?`)) {
                return;
            }

            const formData = new FormData();
            formData.append('id', id);

            try {
                const response = await fetch('../crud/eliminar.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    mostrarAlerta(data.message, 'success');
                    cargarProductos();
                } else {
                    mostrarAlerta(data.message || 'Error al eliminar', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarAlerta('Error de conexión', 'error');
            }
        }

        // Mostrar alerta
        function mostrarAlerta(mensaje, tipo) {
            const container = document.getElementById('alert-container');
            const alertClass = tipo === 'success' ? 'alert-success' : 'alert-error';
            
            container.innerHTML = `<div class="alert ${alertClass}">${mensaje}</div>`;
            container.querySelector('.alert').style.display = 'block';

            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }
    </script>
</body>
</html>

