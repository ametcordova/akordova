<div id="accordion" style="display:none;">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h5 class="text-info">Administración</h5>
                    </button>
                </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                    <thead class="bg-info">
                        <tr class="text-center">
                        <th scope="col" class="bg-primary">Opción</th>
                        <th scope="col" class="bg-primary">Habilitar</th>
                        <th scope="col">Agregar</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Visualizar</th>
                        <th scope="col">Cancelar</th>
                        <th scope="col">Imprimir</th>
                        <th scope="col">Seleccionar</th>
                        <th scope="col">Activar</th>
                        </tr>
                    </thead>

                    <tbody id="checkeadosadmin">
                        <tr>
                        <th scope="row">Ventas</th>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline habilitaPermisoVentas" type="checkbox" value="0"  id="ventas">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolventas" type="checkbox" value="1" id="actvent">
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">Compras</th>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline habilitaPermisoCompras" type="checkbox" value="1"  id="compras">
                            </td>
                            <td colspan="7" class="text-center">
                            </td>
                        </tr>

                        <tr>
                        <th scope="row">Administrar Ventas</th>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline habilitaPermisoAdminVentas" type="checkbox" value="1"  id="adminventas">
                            </td>
                            <td colspan="2" class="text-center">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline roladminventas" type="checkbox" value="1" id="vieadmi">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline roladminventas" type="checkbox" value="1" id="deladmi">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline roladminventas" type="checkbox" value="1" id="priadmi">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline roladminventas" type="checkbox" value="1" id="seladmi">
                            </td>
                            <td class="text-center">
                            </td>
                        </tr>

                        <tr>
                        <th scope="row">Control de Efectivo</th>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline habilitaPermisoControlEfe" type="checkbox" value="1"  id="controlefectivo">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolcontrolefe" type="checkbox" value="1" id="adicont">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolcontrolefe" type="checkbox" value="1" id="edicont">
                            </td>
                            <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcontrolefe" type="checkbox" value="1" id="viecont">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolcontrolefe" type="checkbox" value="1" id="delcont">
                            </td>
                            <td colspan="3" class="text-center">
                            </td>                        
                        </tr>

                        <tr>
                        <th scope="row">Ajuste de Inventario</th>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline habilitaPermisoAjusteInv" type="checkbox" value="1"  id="ajusteinv">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolajusteinv" type="checkbox" value="1" id="adiajus">
                            </td>
                            <td class="text-center">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolajusteinv" type="checkbox" value="1" id="vieajus">
                            </td>
                            <td class="text-center">

                            </td>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline rolajusteinv" type="checkbox" value="1" id="priajus">
                            </td>
                            <td colspan="2" class="text-center">
                            </td>                        
                        </tr>

                        <tr>
                            <th scope="row">Respaldo de BD</th>
                            <td class="text-center">
                                <input class="form-check-input checkbox-inline habilitaPermisoRespaldo" type="checkbox" value="1"  id="respaldo">
                            </td>
                            <td colspan="7" class="text-center">
                            </td>
                        </tr>
                        
                    </tbody>
                    </table>                    
                    <div class="text-center pt-2 pb-0">
                        <button class="btn btn-info btn-sm" id="guardarPermisoAdmin" type="button"><i class="fa fa-save"></i> Guardar</button>
                    </div>

                </div>
                </div>
            </div>
            <script defer src="vistas/js/administracion.js?v=01092020"></script>            