<?
   ##INCLUDES
   	require_once('../lib/config.php');

   #CONTROLE SESSAO
   	fnInicia_Sessao('audit');

   #INPUTS
   	$PESQUISA     = addslashes($_REQUEST['pesquisa']);
   	$DAT_INICIO   = addslashes($_REQUEST['dat_inicio']);
   	$DAT_FIM 	= addslashes($_REQUEST['dat_fim']);
   	$DAT_COMPLETA = addslashes($_REQUEST['dat_completa']);

   	$menos30dias = time( ) - 86400 * 30;

   	if ($DAT_INICIO == '') $DAT_INICIO = date('Y-m-d', $menos30dias);
   	if ($DAT_FIM == '') $DAT_FIM = date('Y-m-d');
   	if ($DAT_COMPLETA == '')	$DAT_COMPLETA = date('d/m/Y', $menos30dias).' - '.date('d/m/Y');

   #INICIO LOGICA
   	$DB = fnDBConn();
   	$SQL = "SELECT USER.FIRSTNAME, USER.LASTNAME, USER.LOGIN, AUDIT.IP, AUDIT.ACTION_DESC, DATE_FORMAT(AUDIT.DIN,'%d/%m/%Y<br>%h:%i:%s') DIN FROM AUDIT, USER
   			WHERE USER.ID = AUDIT.ID_USER
   			  AND (AUDIT.ACTION_DESC LIKE '%$PESQUISA%' OR
   				  USER.FIRSTNAME LIKE '%$PESQUISA%' OR
   				  USER.LOGIN LIKE '%$PESQUISA%')
   			  AND AUDIT.DIN BETWEEN '$DAT_INICIO 23:59:59' AND '$DAT_FIM 23:59:59'
   			ORDER BY AUDIT.ID DESC";

   	$RET = fnDB_DO_SELECT_WHILE($DB,$SQL);

   include('../imports/header.php');
   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
   <div class="page-content">
      <? include('../imports/alert.php'); ?>
      <!-- BEGIN PAGE HEADER-->
      <div class="row">
         <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
               Audit <small></small>
            </h3>
            <!--button type="button" class="btn red" style="right: 15px; position: absolute; margin-top: -40px" onClick="parent.location='novo.php'">Novo Cliente</button-->
            <!-- END PAGE TITLE & BREADCRUMB-->
         </div>
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PORTLET -->
      <div class="portlet gren">
         <div class="portlet-title">
            <div class="caption">Search Details</div>
         </div>
         <div class="portlet-body form">
            <form role="form">
               <input type="hidden" name="dat_inicio" id="dat_inicio" value="" />
               <input type="hidden" name="dat_fim" id="dat_fim" value="" />
               <input type="hidden" name="dat_completa" id="dat_completa" value="" />
               <div class="form-body">
                  <div class="row form-group">
                     <div class="col-md-8">
                        <label>Pesquisa</label>
                        <input type="text" name="pesquisa" class="form-control" placeholder="Digite o termo de pesquisa..." value="<?=$PESQUISA?>">
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <label>Período da Pesquisa</label>
                        <div id="reportrange" class="form-control">
                           <i class="fa fa-calendar"></i>
                           <span>&nbsp;</span>
                           <b class="fa fa-angle-down"></b>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-actions">
                  <button type="submit" class="btn red">Pesquisar</button>
               </div>
            </form>
         </div>
      </div>
      <!-- END PORTLET -->
      <!-- BEGIN SAMPLE TABLE PORTLET-->
      <div class="portlet-body flip-scroll">
         <table class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
               <tr>
                  <th>
                     Usuário
                  </th>
                  <th>
                     IP
                  </th>
                  <th class="numeric">
                     Ação
                  </th>
                  <th class="numeric">
                     Hora
                  </th>
               </tr>
            </thead>
            <tbody>
               <?
                  foreach($RET as $KEY => $ROW)
                  	{
                  	$ROW['FIRSTNAME'] = str_ireplace($PESQUISA,'<FONT style="BACKGROUND-COLOR: yellow">'.$PESQUISA.'</FONT>',$ROW['FIRSTNAME']);
                  	$ROW['LOGIN'] = str_ireplace($PESQUISA,'<FONT style="BACKGROUND-COLOR: yellow">'.$PESQUISA.'</FONT>',$ROW['LOGIN']);
                  	$ROW['ACTION_DESC'] = str_ireplace($PESQUISA,'<FONT style="BACKGROUND-COLOR: yellow">'.$PESQUISA.'</FONT>',$ROW['ACTION_DESC']);
                  	?>
               <tr>
                  <td>
                     <?=$ROW['FIRSTNAME']?><br><?=$ROW['LOGIN']?>
                  </td>
                  <td>
                     <?=$ROW['IP']?>
                  </td>
                  <td>
                     <?=$ROW['ACTION_DESC']?>
                  </td>
                  <td>
                     <?=$ROW['DIN']?>
                  </td>
               </tr>
               <?
                  }
                  ?>
            </tbody>
         </table>
      </div>
   </div>
   <!-- END SAMPLE TABLE PORTLET-->

<!-- END CONTENT -->
<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
<script>
   jQuery(document).ready(function() {
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   QuickSidebar.init() // init quick sidebar
   ComponentsPickers.init();

   $('#reportrange span').html('<?=$DAT_COMPLETA?>');
   $('#dat_inicio').val('<?=$DAT_INICIO?>');
   $('#dat_fim').val('<?=$DAT_FIM?>');
   $('#dat_completa').val('<?=$DAT_COMPLETA?>');
   });

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
