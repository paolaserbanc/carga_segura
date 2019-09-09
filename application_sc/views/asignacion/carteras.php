      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Asignacion</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Mandante</th>
                          <th>Codigo</th>
                          <th>Nombre</th>
                          <th>Base de Datos</th>
                          <th>Hora Proceso</th>
                          <th>Resultado</th>
                          <th class="disabled-sorting text-right">Acciones</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <th>Mandante</th>
                          <th>Codigo</th>
                          <th>Nombre</th>
                          <th>Base de Datos</th>
                          <th>Hora Proceso</th>
                          <th>Resultado</th>                          
                          <th class="disabled-sorting text-right">Acciones</th>
                      </tfoot>
                      <tbody>
                      
                      <?php if(!empty($carteras)){ foreach($carteras as $t){ ?>
                        <tr>
                          <td><?=$t['CLIENTE']?></td>
                          <td><?=$t['codigo_cartera']?></td>
                          <td><?=$t['NOMBRE']?></td>
                          <td><?=$t['BASEDATOS']?></td>
                          <td><?=$t['hora_ejecucion']?></td> 
                          <?php
                          if(!empty($t['finalizo_exito']) && $t['finalizo_exito'] == 'S') {
                                $icon = 'done';
                                $color = 'success';
                                $id_log = $t['id_log'];
                          } else {
                                $icon = 'close';
                                $color = 'danger';
                                if(empty($t['id_log'])){
                                    $id_log = 0;
                                } else {
                                   $id_log =  $t['id_log'];
                                }
                                
                          }
                          ?> 
                          <th><a title="Ver Log" id="log_<?php echo $id_log ?>" href="#" class="ver_log btn btn-link btn-<?php echo $color ?> btn-just-icon remove" data-toggle="modal" data-target="#verLog"><i class="material-icons"><?php echo $icon ?></i></a></th>                      
                         <!-- Para operaciones el menu seria "Validar carga, reportar problema, bla bla" -->
                          <td class="text-right">
                            <a title="Cuadratura" id="cuadratura_<?php echo $id_log ?>"  href="#" class="ver_cuadratura btn btn-link btn-warning btn-just-icon edit" data-toggle="modal" data-target="#verCuadratura"><i class="material-icons">event_note</i></a>
                            <a title="Reprocesar" href="#" class="btn btn-link btn-success btn-just-icon edit"><i class="material-icons">sync_problem</i></a> 
                            <a title="Cargar Fonos" href="#" class="btn btn-link btn-info btn-just-icon edit"><i class="material-icons">call</i></a>  
                            <a title="Ir a E-Collection" href="<?='172.16.10.15'.$t['PATH']?>"><i class="material-icons">info</i></a>                          
                          </td>
                        </tr>
                       <?php } }?>

                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- end content-->
              </div>
              <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
          </div>
          <!-- end row -->
        </div>
      </div>
      <div class="modal fade" id="verLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Log de Carga</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="material-icons">clear</i>
              </button>
            </div>
            <div class="modal-body">
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
      
      <div class="modal fade" id="verCuadratura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
             
              
            </div>
            <div class="modal-body-ver_cuadratura">
          
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>
<script>
    $('.ver_log').click(function(){
        id = $('.ver_log').attr('id');
        id_log = $('.ver_log').attr('id').split('_');
        if(id_log[1] == 0) { //No se ha procesado
            $('.modal-body').html('No se ha procesado la asignación.')
        } else {
            
           $.ajax({
			type:'POST',
			data:{id_log:id_log[1]},
            dataType:"html",
			url:"<?php echo base_url('/index.php/Asignacion/ver_log')?>",
			success:function(data){
                
                $('.modal-body').html(data);
                
			}
		}); 
        }
        
    });
    
    $('.ver_cuadratura').click(function(){
        id = $('.ver_cuadratura').attr('id');
        id_log = $('.ver_cuadratura').attr('id').split('_');
        if(id_log[1] == 0) { //No se ha procesado
            $('.modal-body-ver_cuadratura').html('No se ha procesado la asignación.')
        } else {
            
           $.ajax({
			type:'POST',
			data:{id_log:id_log[1]},
            dataType:"html",
			url:"<?php echo base_url('/index.php/Asignacion/ver_cuadratura')?>",
			success:function(data){
                
                $('.modal-body-ver_cuadratura').html(data);
                
			}
		}); 
        }
        
    });
    
</script>