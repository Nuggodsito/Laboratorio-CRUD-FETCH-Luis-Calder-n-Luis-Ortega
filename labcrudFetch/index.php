<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD php - API fetch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">Registro de productos</h3>
                    </div>
                    <div class="card-body">
                        <form id="frm">
                            <input type="hidden" name="idp" id="idp" value="">
                            <input type="hidden" name="Accion" id="Accion" value="Guardar">
                            
                            <div class="form-group mb-3">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" id="codigo" placeholder="Código" class="form-control">
                                <div class="text-danger" id="error-codigo"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="producto">Producto</label>
                                <input type="text" name="producto" id="producto" placeholder="Descripción" class="form-control">
                                <div class="text-danger" id="error-producto"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="precio">Precio</label>
                                <input type="text" name="precio" id="precio" placeholder="Precio" class="form-control">
                                <div class="text-danger" id="error-precio"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="cantidad">Cantidad</label>
                                <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control">
                                <div class="text-danger" id="error-cantidad"></div>
                            </div>
                            
                            <div class="form-group">
                                <button type="button" id="btnAccion" class="btn btn-primary btn-block" onclick="procesarFormulario()">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="row mb-3">
                    <div class="col-lg-6 ms-auto">
                        <div class="form-group">
                            <label for="buscar">Buscar:</label>
                            <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control" onkeyup="buscarProductos()">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="resultado">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>