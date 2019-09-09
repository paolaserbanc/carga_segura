      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10">
              <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Tipo de Extracción</h4>
                </div>
                <div class="card-body">
                  <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                  </div>
                  <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Tipo</th>
                          <th>Fecha Creacion</th>
                          <th>Fecha Modf</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Id</th>
                          <th>Tipo</th>
                          <th>Fecha Creacion</th>
                          <th>Fecha Modf</th>
                          <th class="disabled-sorting text-right">Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                      <?php foreach($tipo_extraccion as $t){ ?>
                        <tr>
                          <td><?=$t['id_tipo_extraccion']?></td>
                          <td><?=$t['tipo_extraccion']?></td>
                          <td><?=$t['fecha_creacion']?></td>
                          <td><?=$t['fecha_modificacion']?></td>
                          <td class="text-right">
                            <a href="#" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">favorite</i></a>
                            <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                            <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                          </td>
                        </tr>
                       <?php }?>

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