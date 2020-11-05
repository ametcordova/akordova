<div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h5 class="text-success">Catálogos</h5>
                        </button>
                    </h5>
                </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                <!-- <form role="form" id="formPermisoCat" method="post">-->
                <table class="table table-bordered table-sm">
                <thead class="bg-info">
                        <tr class="text-center">
                        <th scope="col" class="bg-primary">Opción</th>
                        <th scope="col" class="bg-primary">Habilitar</th>
                        <th scope="col">Agregar</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Visualizar</th>
                        <th scope="col">Eliminar</th>
                        <th scope="col">Imprimir</th>
                        <th scope="col">Seleccionar</th>
                        <th scope="col">Activar</th>
                        </tr>
                    </thead>

                    <tbody id="checkeadoscata">
                        
                        <tr>
                        <th scope="row">Productos</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoProd" type="checkbox" value="0" name="productos" id="productos">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproducto" type="checkbox" value="1" id="adiprod">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproducto" type="checkbox" value="1"  id="ediprod">
                        </td>
                        <td class="text-center">
                            
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproducto" type="checkbox" value="1" id="delprod">
                        </td>
                        <td class="text-center">
                            
                        </td>
                        <td class="text-center">
                            
                        </td>
                        <td class="text-center">
                            
                        </td>
                        </tr>

                        <tr >
                        <th scope="row">Categorias</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoCategoria" type="checkbox" value="0" name="categorias" id="categorias">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcategoria" type="checkbox" value="1" id="adicate">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcategoria" type="checkbox" value="1"  id="edicate">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcategoria" type="checkbox" value="1"  id="viecate">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcategoria" type="checkbox" value="1" id="delcate">
                        </td>
                        <td class="text-center">
                        </td>
                        <td class="text-center">
                        </td>
                        <td class="text-center">
                        </td>
                        </tr>
                        
                        <tr>
                        <th scope="row">Familias</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoFamilia" type="checkbox" value="0" name="familia" id="familias">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolfamilia" type="checkbox" value="1" id="adifami">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolfamilia" type="checkbox" value="1" id="edifami">
                        </td>

                        <td class="text-center">
                        </td>

                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolfamilia" type="checkbox" value="1" id="delfami">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                        </td>

                        <td class="text-center">
                        </td>

                        </tr>                        

                        <tr>
                        <th scope="row">U. de Medidas</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoMedida" type="checkbox" value="0" name="medida" id="medidas">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolmedida" type="checkbox" value="1" id="adimedi">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolmedida" type="checkbox" value="1" id="edimedi">
                        </td>

                        <td class="text-center">
                        </td>

                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolmedida" type="checkbox" value="1" id="delmedi">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                        </td>

                        <td class="text-center">
                        </td>
                        </tr>                        

                        <tr>
                        <th scope="row">Proveedores</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoProveedor" type="checkbox" value="0" name="proveedor" id="proveedores">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproveedor" type="checkbox" value="1" id="adiprov">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproveedor" type="checkbox" value="1" id="ediprov">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproveedor" type="checkbox" value="1" id="vieprov">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproveedor" type="checkbox" value="1" id="delprov">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolproveedor" type="checkbox" value="1" id="actprov">
                        </td>
                        </tr>     

                        <tr>
                        <th scope="row">Clientes</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoCliente" type="checkbox" value="0" name="clientes" id="clientes">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="adiclie">
                        </td>
                        <td class="text-center rolcliente">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="ediclie">
                        </td>
                        <td class="text-center rolcliente">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="vieclie">
                        </td>
                        <td class="text-center rolcliente">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="delclie">
                        </td>
                        <td class="text-center rolcliente">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="priclie">
                        </td>
                        <td class="text-center rolcliente">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="selclie">
                        </td>
                        <td class="text-center rolcliente">
                            <input class="form-check-input checkbox-inline rolcliente" type="checkbox" value="1" id="actclie">
                        </td>
                        </tr>                        

                        <tr>
                        <th scope="row">Crear Almacén</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoAlmacen" type="checkbox" value="0" name="almacen" id="almacenes">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolalmacen" type="checkbox" value="1" id="adialma">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolalmacen" type="checkbox" value="1" id="edialma">
                        </td>

                        <td class="text-center">
                        </td>

                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolalmacen" type="checkbox" value="1" id="delalma">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                        </td>

                        <td class="text-center">
                        </td>
                        </tr>                   

                        <tr>
                        <th scope="row">Caja de Venta</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoCajaventa" type="checkbox" value="0" name="cajaventa" id="cajaventas">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcajaventa" type="checkbox" value="1" id="adicaja">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcajaventa" type="checkbox" value="1" id="edicaja">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcajaventa" type="checkbox" value="1" id="viecaja">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcajaventa" type="checkbox" value="1" id="delcaja">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline rolcajaventa" type="checkbox" value="1" id="actcaja">
                        </td>
                        </tr>   

                        <tr>
                        <th scope="row">Tipos de Mov.</th>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline habilitaPermisoTipMov" type="checkbox" value="0" name="tiposmov" id="tiposmov">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline roltipomov" type="checkbox" value="1" id="aditipo">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline roltipomov" type="checkbox" value="1" id="editipo">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline roltipomov" type="checkbox" value="1" id="vietipo">
                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline roltipomov" type="checkbox" value="1" id="deltipo">
                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">

                        </td>
                        <td class="text-center">
                            <input class="form-check-input checkbox-inline roltipomov" type="checkbox" value="1" id="acttipo">
                        </td>
                        </tr>   

                    </tbody>

                </table> 
                
                   <div class="text-center pt-2 pb-0">
                    <button class="btn btn-success btn-sm" id="guardarPermisoCat"  type="button"><i class="fa fa-save"></i> Guardar</button>
                   </div>
                <!-- </form> -->
                </div>
              </div>
            </div>  <!--fin de card   -->
            <script defer src="vistas/js/catalogos.js?v=01092020"></script>