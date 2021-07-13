


<?php
require_once '../../model/extordentrabajo.php';
session_start();
//  $rango='';

$rango = $_REQUEST['rango'];
$artsemi = $_REQUEST['artsemi'];


$fecinicio = substr($rango, 0, 10);
$fecfinal = substr($rango, 13, 21);

$fecini = date_create($fecinicio);
$ini = date_format($fecini, 'Y-m-d');

$fecfin = date_create($fecfinal);
$fin = date_format($fecfin, 'Y-m-d');

$fecha = date('Y-m-d',strtotime($ini."- 1 days")); 
//$area = new opedido();
//$areas = $area->consultar2($ini,$fin);

$kardexs = new extordentrabajo();
$lista = $kardexs->kardexs($ini, $fin, $artsemi);

$saldo_inicial = $kardexs->SaldoInicial($fecha, $artsemi);
$acumulado = 0;
?> 

<div class="widget-body">
    <div class="widget-main">

        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue">Lista según siguiente filtro: <?php echo $ini . ' - ' . $fin . '--> Código del artículo:' . $artsemi; ?> </h3>
                <div class="clearfix">
                    <div class="pull-right tableTools-container"></div>
                </div>
                <div class="table-header">
                    Resultados del filtro: <?php echo $ini . ' - ' . $fin . '--> Código del artículo:' . $artsemi; ?> 
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-flat">
                                <h4 class="widget-title lighter">
                                    <i class="ace-icon fa fa-star orange"></i>
                                    Movimientos del artículo
                                </h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                            <tr>
                                                <th>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>Id-mov
                                                </th>

                                                <th>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>Tipo Documento
                                                </th>

                                                <th class="hidden-480">
                                                    <i class="ace-icon fa fa-caret-right blue"></i>Fecha
                                                </th>
                                                <th>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>Cantidad
                                                </th>

                                                <th class="hidden-480">
                                                    <i class="ace-icon fa fa-caret-right blue"></i>Stock
                                                </th>
                                                <th>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>Lote
                                                </th>


                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td></td>

                                                <td>
                                                   
                                                </td>

                                                <td class="hidden-480">
                                                    <span class="label label-info arrowed-right arrowed-in">Saldo Inicial</span>
                                                </td>

                                                
                                                <td>
                                                      <?php if($saldo_inicial):?>
                                            <?php foreach ($saldo_inicial as $list): ?>
                                                    <b class="green"> <?php echo $list['stock'];?></b>
                                                     <?php $acumulado =  $list['stock']; ?>
                                                     <?php endforeach; ?>
                                            <?php endif; ?>
                                                </td>
                                                 <td>
                                                   
                                                    <b class="blue"></b>
                                                </td>
                                                <td class="hidden-480">
                                                    <span class="label label-info arrowed-right arrowed-in"></span>
                                                </td>
                                            </tr>

                                            <?php if($lista):?>
                                            <?php foreach ($lista as $list): ?>
                                              <tr>
                                                <td><?php echo $list["promov_id"];?></td>
                                                 <td>  <span class="<?php echo $list["tipdoc_tipletra"];?>"><?php echo $list["tipdoc_titulo"];?></span></td>
                                                  <td><?php echo $list["fecdoc"];?></td>
                                                   <td>  <b class="green"><?php echo $list["promov_cant_mov"];?></b></td>
                                                     <?php $acumulado = $acumulado +   $list['promov_cant_mov']; ?>
                                                    <td> <b class="blue"><?php echo $acumulado;?></b></td>
                                                     <td><?php echo $list["promov_lote"];?></td>
                                            </tr>
                                            
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                         
<tr>
                                                <td></td>

                                                <td>
                                                   
                                                </td>

                                                <td class="hidden-480">
                                                    <span class="label label-info arrowed-right arrowed-in">Saldo Final</span>
                                                </td>

                                                
                                                <td>
                                                   
                                                    <b class="green"><?php echo $acumulado;?></b>
                                                </td>
                                                 <td>
                                                   
                                                    <b class="blue"></b>
                                                </td>
                                                <td class="hidden-480">
                                                    <span class="label label-info arrowed-right arrowed-in"></span>
                                                </td>
                                            </tr>
            
                                        </tbody>
                                    </table>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div>
                        <!-- /.widget-box -->
                    </div><!-- /.col -->
                </div>

            </div>
        </div>
    </div>
</div>





<script src="assets/js/bootbox.js"></script>
