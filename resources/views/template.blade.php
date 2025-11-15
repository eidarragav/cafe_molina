@include("navbar")

<div class="container mt-4">

    <!-- Form Section -->
    <div class="cafe-section">
        <h3>📝 Crear Nuevo Registro</h3>
        <form action="#" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="col-md-6">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-cafe">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </form>
    </div>

    <!-- Table Section -->
    <div class="cafe-section">
        <h3>📊 Listado de Registros</h3>
        <div class="table-responsive">
            <table class="table table-cafe table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Juan Pérez</td>
                        <td>juan@example.com</td>
                        <td>+34 123 456 789</td>
                        <td>Calle Principal 123</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info btn-action">Ver</a>
                            <a href="#" class="btn btn-sm btn-warning btn-action">Editar</a>
                            <button class="btn btn-sm btn-danger btn-action">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>María García</td>
                        <td>maria@example.com</td>
                        <td>+34 987 654 321</td>
                        <td>Avenida Central 456</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info btn-action">Ver</a>
                            <a href="#" class="btn btn-sm btn-warning btn-action">Editar</a>
                            <button class="btn btn-sm btn-danger btn-action">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
@include("footer")
</html>