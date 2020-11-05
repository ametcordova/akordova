 <div class="card">
     <div class="card-header" id="headingThree">
         <h5 class="mb-0">
             <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                 <h5>Reportes</h5>
             </button>
         </h5>
     </div>
     <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                 <thead class="bg-info">
                     <tr class="text-center">
                         <th scope="col" class="bg-primary">Opción</th>
                         <th scope="col" class="bg-primary">Habilitar</th>
                         <th scope="col">Visualizar</th>
                         <th scope="col">Imprimir</th>
                         <th scope="col">&nbsp &nbsp &nbsp   </th>
                         <th scope="col">&nbsp &nbsp &nbsp   </th>
                     </tr>
                 </thead>

                 <tbody id="checkeadosreportes">

                    <tr>
                         <th scope="row">Rep. de Ventas</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepVentas" type="checkbox" value="0" id="rvtas">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepvtas" type="checkbox" value="1"  id="viervta">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepvtas" type="checkbox" value="1" id="prirvta"> 
                         </td>

                         <td colspan="2" class="text-center">
                         </td>
                    </tr>


                     <tr>
                         <th scope="row">Rep. de compras</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepCompras" type="checkbox" value="0" id="rcompras">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepcompras" type="checkbox" value="1"  id="viercom">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepcompras" type="checkbox" value="1" id="prircom"> 
                         </td>

                         <td colspan="2" class="text-center">
                         </td>
                     </tr>

                     <tr>
                         <th scope="row">Rep. de Inventario</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepInv" type="checkbox" value="0" id="rinv">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepinv" type="checkbox" value="1"  id="vierinv">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepinv" type="checkbox" value="1" id="pririnv"> 
                         </td>

                         <td colspan="2" class="text-center">
                         </td>
                     </tr>

                     <tr>
                         <th scope="row">Cortes de Venta</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepCV" type="checkbox" value="0" id="rcortes">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepcv" type="checkbox" value="1"  id="viercor">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepcv" type="checkbox" value="1" id="prircor"> 
                         </td>

                         <td colspan="2" class="text-center">
                         </td>
                     </tr>

                     <tr>
                         <th scope="row">Kardex de Producto</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepkardex" type="checkbox" value="0" id="rkardex">
                         </td>

                         <td  class="text-center">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepkardex" type="checkbox" value="1" id="prirkar"> 
                         </td>
                         <td colspan="2" class="text-center">
                         </td>
                     </tr>
                     <tr>
                         <th scope="row">Sugerido de compra</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepSug" type="checkbox" value="0" id="rsugerido">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepsugerido" type="checkbox" value="1"  id="viersug">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepsugerido" type="checkbox" value="1" id="prirsug"> 
                         </td>
                         <td colspan="2" class="text-center">
                         </td>
                     </tr>

                     <tr>
                         <th scope="row">Reporte de cancelaciones</th>
                         <td class="text-center">
                             <input class="form-check-input checkbox-inline habilitaPermisoRepCanc" type="checkbox" value="0" id="rcancela">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepcancela" type="checkbox" value="1"  id="viercan">
                         </td>

                         <td class="text-center">
                            <input class="form-check-input checkbox-inline rolrepcancela" type="checkbox" value="1" id="prircan"> 
                         </td>
                         <td colspan="2" class="text-center">
                         </td>
                     </tr>                     
                 </tbody>

             </table>

             <div class="text-center pt-2 pb-0">
                 <button class="btn btn-primary btn-sm" id="guardarPermisoRep" type="button"><i class="fa fa-save"></i> Guardar</button>
             </div>

        </div>      <!--fin de card-body   -->
     </div>
 </div> <!--fin de card   -->
 <script defer src="vistas/js/report.js?v=01092020"></script>