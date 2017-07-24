<?
  // #INCLUDES
  require_once ('../lib/config.php');
  require_once('../models/Study.php');
  require_once('../models/InterfaceLanguage.php');
  require_once('../models/BaseTheory.php');
  require_once('../models/Variation.php');
  require_once('../models/Line.php');

  if (empty($_REQUEST['s'])){
    header('Location: ./');
    exit;
  }

  // CONTROLE SESSAO
  fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  #BUSCAR TODAS AS VARIÁVEIS GET
  $paramStudy = $_REQUEST['s'];
  $visibleTab = $_REQUEST['tb'];

  $tbHistory = "";
  $tbGameStyle = "";
  $tbMainGrandMasters = "";
  $tbVariations = "";
  $tbLines = "";
  $tbBibliography = "";

  switch ($visibleTab) {
    case "history":
        $tbHistory = "active";
        break;
    case "gameStyle":
        $tbGameStyle = "active";
        break;
    case "mainGrandMasters":
        $tbMainGrandMasters = "active";
        break;
    case "variations":
        $tbVariations = "active";
        break;
    case "lines":
        $tbLines = "active";
        break;
    case "bibliography":
        $tbBibliography = "active";
        break;
    default:
        $tbLines = "active";
        break;
  }

  //escondendo estudo, variations e linhas deletadas
  Study::$showDeleted = false;
  Study::$showVariationDeleted = false;
  Study::$showLineDeleted = false;

  $study = new Study();
  $study = $study->getStudyWithID($paramStudy);

  $user = new User();
  $study->author = $user->getUserWithID($userID);

  if ($study->author->id != $userID){
    header('Location: ./');
    exit;
  }

  if ($study->deleted == true){
    header('Location: ./');
    exit;
  }

  $baseTheory = new BaseTheory();
  $study->baseTheory = $baseTheory->getBaseTheoryForStudy($study->id);

  $variation = new Variation();
  $study->variations = $variation->getAllVariationsForStudy($study->id);

  $eco = new Eco();
  $arrEcos = $eco->getALlEcos();

  $study->eco = $eco->getEcoForStudy($study->id);

  $variationsCount = count($study->variations);

  Line::$orderBy = " ORDER BY OSTL.DIN DESC";
  $line = new Line();
  $arrLines = $line->getAllLinesForStudy($paramStudy);

  $linesCount = count($arrLines);

  $studyID = $study->id;

  include('../imports/header.php');
  include('../imports/opening_styles.php');
?>
<script>
  function resizeIframe(obj) {
    //faz um iframe aparecer inteiro, de acordo com o height do conteúdo que será apresentado
   // obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<div class="page-content-wrapper">
<div class="page-content">
  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
  <div class="row">
    <div class="col-md-12">
      <h3 class="page-title">
        Theory<small></small>
      </h3>
    </div>
  </div>
  <div class="page-bar">
    <ul class="page-breadcrumb">
      <li>
         <i class="fa fa-home"></i>
         <a href="#">Openings</a>
         <i class="fa fa-angle-right"></i>
      </li>
      <li>
        <a href="./list.php">Builder</a>
        <i class="fa fa-angle-right"></i>
      </li>
      <li>
        <a href="details.php?s=<?=$study->id?>"><?=$study->name?></a>
        <i class="fa fa-angle-right"></i>
      </li>
      <li>
        <a href="#">Theory</a>
      </li>
    </ul>
  </div>
  <!-- END PAGE TITLE & BREADCRUMB-->
  <? include('../imports/alert.php'); ?>

  <div class="row">
    <div class="col-md-12">
      <!-- BEGIN TODO SIDEBAR -->
      <div class="todo-ui">
        <div class="todo-sidebar">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                <span class="caption-subject font-green-sharp bold uppercase">Base Theory </span>
              </div>
            </div>
            <!--  BEGIN MENU APRENDIZADO -->
            <div class="row">
              <ul class="ver-inline-menu tabbable margin-bottom-10">
                <li class="<?=$tbHistory?>">
                  <a data-toggle="tab" href="#tab_1">
                  <i class="fa fa-birthday-cake"></i> History </a>
                </li>
                <li class="<?=$tbGameStyle?>">
                  <a data-toggle="tab" href="#tab_2">
                  <i class="fa fa-puzzle-piece"></i> Game style </a>
                </li>
                <li class="<?=$tbMainGrandMasters?>">
                  <a data-toggle="tab" href="#tab_3">
                  <i class="fa fa-users"></i> Main Grandmasters </a>
                </li>
                <li class="<?=$tbVariations?>">
                  <a data-toggle="tab" href="#tab_4">
                  <i class="fa fa-minus"></i> Variations </a>
                </li>
                <li class="<?=$tbLines?>">
                  <a data-toggle="tab" href="#tab_5">
                  <i class="fa fa-bars"></i> Lines </a>
                </li>
                <li class="<?=$tbBibliography?>">
                  <a data-toggle="tab" href="#tab_6">
                  <i class="fa fa-graduation-cap"></i> Bibliography </a>
                </li>
              </ul>
            </div>
            <!--  FIM MENU APRENDIZADO -->
          </div>
        </div>
        <!-- END TODO SIDEBAR -->
        <!-- BEGIN TODO CONTENT -->
        <div class="todo-content">
          <div class="portlet light">
            <!-- PROJECT HEAD -->
            <div class="portlet-title">
              <div class="caption">
                <i class="icon-bar-chart font-green-sharp hide"></i>
                <span class="caption-helper">OPENING:</span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase"><?=$study->eco->name?></span>
              </div>
            </div>
            <!-- end PROJECT HEAD -->
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="tab-content">
                    <div id="tab_1" class="tab-pane <?=$tbHistory?>">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> History</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <form method="post" id="formHistory" class="form-horizontal" action="./action/theory-history.php">
                            <input type="hidden" id="studyID" name="studyID" value="<?=$study->id?>" />
                            <input type="hidden" id="theoryHistoryID" name="theoryHistoryID" value="<?=$study->baseTheory->theoryHistory->id?>" />
                            <textarea id="textHistory" name="textHistory" maxlength="1000" class="wysihtml5 form-control" rows="6" placeholder="">
                              <?=$study->baseTheory->theoryHistory->text?>
                            </textarea>
                            <span class="help-block">
                              <button type="button" class="btn btn-lg btn-primary" id="btnSaveHistory" title="Save"><i class="fa fa-floppy-o"></i></button>
                            </span>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div id="tab_2" class="tab-pane <?=$tbGameStyle?>">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Game Style</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <form method="post" id="formGameStyle" class="form-horizontal" action="./action/theory-gameStyle.php">
                            <input type="hidden" id="studyID" name="studyID" value="<?=$study->id?>" />
                            <input type="hidden" id="theoryGameStyleID" name="theoryGameStyleID" value="<?=$study->baseTheory->theoryGameStyle->id?>" />
                            <textarea id="textGameStyle" name="textGameStyle" class="wysihtml5 form-control" rows="6" placeholder="">
                              <?=$study->baseTheory->theoryGameStyle->text?>
                            </textarea>
                            <span class="help-block">
                              <button type="button" class="btn btn-lg btn-primary" id="btnSaveGameStyle" title="Save"><i class="fa fa-floppy-o"></i></a>
                            </span>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div id="tab_3" class="tab-pane <?=$tbMainGrandMasters?>">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Main Grandmasters</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <form method="post" id="formMainGrandMasters" name="textMainGrandMasters" class="form-horizontal" action="./action/theory-mainGrandMasters.php">
                            <input type="hidden" id="studyID" name="studyID" value="<?=$study->id?>" />
                            <input type="hidden" id="theoryMainGrandMastersID" name="theoryMainGrandMastersID" value="<?=$study->baseTheory->theoryMainGrandMasters->id?>" />
                          <textarea id="textMainGrandMasters" name="textMainGrandMasters" class="wysihtml5 form-control" rows="6" placeholder="">
                            <?=$study->baseTheory->theoryMainGrandMasters->text?>
                          </textarea>
                          <span class="help-block">
                            <button type="button" class="btn btn-lg btn-primary" id="btnSaveMainGrandMasters" title="Save"><i class="fa fa-floppy-o"></i></button>
                          </span>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div id="tab_4" class="tab-pane <?=$tbVariations?>">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Variations</span>
                          </div>
                          <div class="actions">
                            <a class="openModalVariation btn btn-lg btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> NEW VARIATION</a>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <?php if ($variationsCount < 1): ?>
                          <small>This study does not have any Variation yet.</small>
                          <?php else: ?>
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>
                                  Name
                                </th>
                                <th>
                                  ECO
                                </th>
                                <th>
                                  Description
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($study->variations as $key => $variation): ?>
                                <tr class="openModalVariation" data-toggle="modal" data-varid="<?=$variation->id?>" data-name="<?=$variation->name?>" data-text="<?=$variation->text?>" data-eco="<?=$variation->eco->id?>">
                                  <td>
                                    <?=$variation->name ?>
                                  </td>
                                  <td>
                                    <?=$variation->eco->code ?>
                                  </td>
                                  <td>
                                    <?=substr($variation->text, 0, 90)."..." ?>
                                  </td>
                                </tr>

                              <?php endforeach; ?>
                            </tbody>
                          </table>
                          <span class="badge badge-roundless badge-danger">NOTE</span>
                          <small>Click on any of the above Variations to open editor mode.</small>
                          <?php endif; ?>
                        </div>
                      </div>

                      <div id="modalVariation" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title">Opening Variation</h4>
                            </div>
                            <div class="modal-body form">
                              <form id="formVariation" name="formVariation" method="post" class="form-horizontal">
                                <input type="hidden" id="studyID" name="studyID" value="<?=$studyID?>" />
                                <input type="hidden" id="variationID" name="variationID" value="" />
                                <div class="form-body">
                                <div class="form-group">
                                  <label class="col-md-3 control-label">Name</label>
                                  <div class="col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                      <i class="fa fa-tag"></i>
                                      </span>
                                      <input type="text" id="variationName" name="variationName" class="form-control" value=""/>
                                    </div>
                                    <p class="help-block">
                                      E.g: Advanced Variation<br>
                                    </p>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-md-3 control-label">ECO Opening</label>
                                  <div class="col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                      <i class="fa fa-tag"></i>
                                      </span>
                                      <select class="form-control select2me" name="variationEcoCode" id="variationEcoCode">
                                         <option value="">Select...</option>
                                         <?php foreach ($arrEcos as $key => $eco): ?>
                                           <option value="<?=$eco->id?>" <?=$selected?>>[<?=$eco->code?>] - <?=$eco->name?> (<?=$eco->line?>)</option>
                                         <?php endforeach; ?>
                                      </select>
                                    </div>
                                    <span class="help-block">
                                    If you don't know what is the ECO code, please consider read <a href="https://en.wikipedia.org/wiki/List_of_chess_openings">this</a>.</span>
                                  </div>
                                </div>

                                <div class="form-group last">
                                  <label class="col-md-3 control-label">Description</label>
                                  <div class="col-md-6">
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                      <i class="fa fa-info"></i>
                                      </span>
                                      <textarea class="form-control" rows="4" name="variationText" id="variationText"></textarea>
                                    </div>
                                    <p class="help-block">
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
                              <button type="button" id="btnSaveVariation" class="btn btn-primary" data-dismiss="modal" title="Save"><i class="fa fa-floppy-o"></i></button>
                            </div>
                            </form>

                          </div>
                        </div>
                      </div>

                    </div>

                    <div id="tab_5" class="tab-pane <?=$tbLines?>">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Lines</span>
                          </div>
                          <div class="actions">
                            <a data-target="#modalLine" class="openModalLine btn btn-lg btn-primary"><i class="fa fa-plus"></i> NEW LINE</a>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <?php if ($linesCount < 1): ?>
                          <small>This study does not have any Line yet.</small>
                          <?php else :?>
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>
                                    Name
                                  </th>
                                  <th>
                                    Variation
                                  </th>
                                  <th>
                                    Description
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($arrLines as $key => $line): ?>
                                  <tr class="openModalLine" data-toggle="modal" data-toggle="modal" data-lineid="<?=$line->id?>" data-text="<?=$line->text?>" data-varid="<?=$line->variationID?>" data-name="<?=$line->name?>" data-text="<?=$line->text?>" data-pgn="<?=$line->pgn?>">
                                    <td>
                                      <?=$line->name ?>
                                    </td>
                                    <td>
                                      <?=substr($line->nameVariation, 0, 30) ?>
                                    </td>
                                    <td>
                                      <?=substr($line->text, 0, 60)."..." ?>
                                    </td>
                                  </tr>

                                <?php endforeach; ?>
                              </tbody>
                            </table>

                  <span class="badge badge-roundless badge-danger">NOTE</span>
                  <small>Click on any of the above Lines to open editor mode.</small>

                          <?php endif; ?>
                        </div>
                      </div>
                      <div id="modalLine" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">

                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title">Opening Line</h4>
                            </div>
                            <div class="modal-body form">
                              <form id="formLine" method="post" class="form-horizontal form-row-seperated">

                                <input type="hidden" id="studyID" name="studyID" value="<?=$studyID?>" />
                                <input type="hidden" id="lineID" name="lineID" value="" />

                                <div class="form-group">
                                  <div class="col-sm-4">
                                    <label class="control-label">Variation parent</label>
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                      <i class="fa fa-minus"></i>
                                      </span>
                                      <select class="form-control select2me" id="lineVariationID" name="lineVariationID">
                                        <option value="">Select...</option>
                                        <?php foreach ($study->variations as $key => $variation): ?>
                                          <option value="<?=$variation->id?>"><?=$variation->name?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <label class="control-label">Line name</label>
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                      <i class="fa fa-tag"></i>
                                      </span>
                                      <input type="text" id="lineName" placeholder="E.g: Alekhine variation" name="nameNewLine" class="form-control"/>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <label class="control-label">Description</label>
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                      <i class="fa fa-info"></i>
                                      </span>
                                      <input type="text" id="lineText" placeholder="" name="descriptionNewLine" class="form-control"/>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group last">
                                  <div class="col-sm-12">
                                    <div class="portlet-body">
                                      <iframe name="iframeLine" id="iframeLine" onload="resizeIframe(this)" src="" scrolling="yes"
                                        frameborder="0" border="0" cellspacing="0"
                                        style="border-style: none;width: 100%; height: 610px;"></iframe>
                                    </div>
                                  </div>
                                </div>
                            </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                <button type="button" id="btnSaveLine" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="tab_6" class="tab-pane <?=$tbBibliography?>">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Bibliography</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <form id="formBibliography" class="form-horizontal" action="">
                            <input type="hidden" id="studyID" name="studyID" value="<?=$study->id?>" />
                            <input type="hidden" id="theoryBibliographyID" name="theoryBibliographyID" value="<?=$study->baseTheory->theoryBibliography->id?>" />
                            <textarea id="textBibliography" name="textBibliography" class="wysihtml5 form-control" rows="6">
                              <?=$study->baseTheory->theoryBibliography->text?>
                            </textarea>
                            <span class="help-block">
                              <button type="button" class="btn btn-lg btn-primary" id="btnSaveBibliography" title="Save"><i class="fa fa-floppy-o"></i></button>
                            </span>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- END TODO CONTENT -->
  </div>
</div>
<!-- END PAGE CONTENT-->
<? include('../imports/footer.php'); ?>
<? include('../imports/metronic_core.php'); ?>
</body>
</html>
<script>
  jQuery(document).ready(function() {
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layou
    UIToastr.init();
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "1000",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

    UIAlertDialogApi.init();

    $('#textHistory').wysihtml5();
    $('#textGameStyle').wysihtml5();
    $('#textMainGrandMasters').wysihtml5();
    $('#textBibliography').wysihtml5();

    $(function(){
        $(".openModalVariation").click(function(){
            $('#variationID').val($(this).data('varid'));
            $('#variationName').val($(this).data('name'));
            $('#variationEcoCode').val($(this).data('eco')).trigger('change');
            $('#variationText').val($(this).data('text'));
            $("#modalVariation").modal("show");
        });
    });

    $(function(){
        $(".openModalLine").click(function(){
            $('#lineID').val($(this).data('lineid'));
            $('#lineVariationID').val($(this).data('varid')).trigger('change');
            $('#lineName').val($(this).data('name'));

            if ($(this).data('pgn') != null) {
              $('#iframeLine').attr("src", "../board/pgneditor.php?pgn=" + $(this).data('pgn'));
            }else{
              $('#iframeLine').attr("src", "../board/pgneditor.php");
            }

            $('#lineText').val($(this).data('text'));
            $("#modalLine").modal("show");
        });
    });

    $(document).ready(function () {
      if(sessionStorage.getItem("Success")){
          toastr.success(sessionStorage.getItem("Success"));
          sessionStorage.clear();
      }

      if(sessionStorage.getItem("Warning")){
          toastr.warning(sessionStorage.getItem("Warning"));
          sessionStorage.clear();
      }

      if(sessionStorage.getItem("Info")){
          toastr.info(sessionStorage.getItem("Info"));
          sessionStorage.clear();
      }

      if(sessionStorage.getItem("Error")){
          toastr.error(sessionStorage.getItem("Error"));
          sessionStorage.clear();
      }

    });

    $(document).ready(function () {
          $("#btnSaveHistory").click(function () {
              $.ajax({
                  url: './action/theory-history.php',
                  type: 'POST',
                  data: {studyID: $("#studyID").val(),
                        theoryHistoryID: $("#theoryHistoryID").val(),
                        textHistory: $("#textHistory").val()},
                  success: function (result) {
                    var response = JSON.parse(result);

                    if(response["status"] == "success"){
                      toastr.success('Saved changes!');
                    }else if(response["status"] == "error"){
                      toastr.warning('Error. Please, try again later.');
                    }
                  }, error: function (result) {
                  		toastr.error('Error. Please, try again later.');
              		}
              });
          });
      });

    $(document).ready(function () {
          $("#btnSaveGameStyle").click(function () {
              $.ajax({
                  url: './action/theory-gameStyle.php',
                  type: 'POST',
                  data: {studyID: $("#studyID").val(),
                        theoryGameStyleID: $("#theoryGameStyleID").val(),
                        textGameStyle: $("#textGameStyle").val()},
                  success: function (result) {
                    var response = JSON.parse(result);

                    if(response["status"] == "success"){
                      toastr.success('Saved changes!');
                    }else if(response["status"] == "error"){
                      toastr.warning('Error. Please, try again later.');
                    }
                  }, error: function (result) {
                  		toastr.error('Error. Please, try again later.');
              		}
              });
          });
      });

    $(document).ready(function () {
          $("#btnSaveMainGrandMasters").click(function () {
              $.ajax({
                  url: './action/theory-mainGrandMasters.php',
                  type: 'POST',
                  data: {studyID: $("#studyID").val(),
                        theoryMainGrandMastersID: $("#theoryMainGrandMastersID").val(),
                        textMainGrandMasters: $("#textMainGrandMasters").val()},
                  success: function (result) {
                    var response = JSON.parse(result);

                    if(response["status"] == "success"){
                      toastr.success('Saved changes!');
                    }else if(response["status"] == "error"){
                      toastr.warning('Error. Please, try again later.');
                    }
                  }, error: function (result) {
                  		toastr.error('Error. Please, try again later.');
              		}
              });
          });
      });

    $(document).ready(function () {
          $("#btnSaveVariation").click(function () {
              $.ajax({
                  url: './action/theory-variation.php',
                  type: 'POST',
                  data: {studyID: $("#studyID").val(),
                        variationID: $("#variationID").val(),
                        variationName: $("#variationName").val(),
                        variationEcoCode: $("#variationEcoCode").val(),
                        variationText: $("#variationText").val()},
                  success: function (result) {
                    var response = JSON.parse(result);

                    if(response["status"] == "success"){
                      //mostrar toaster após reload
                      sessionStorage.setItem("Success","Saved changes!");
                      location.reload();
                    }else if(response["status"] == "error"){
                      toastr.warning('Error. Please, try again later.');
                    }
                  }, error: function (result) {
                  		toastr.error('Error. Please, try again later.');
              		}
              });
          });
      });

      $(document).ready(function () {
            $("#btnSaveLine").click(function () {
                $.ajax({
                    url: './action/theory-line.php',
                    type: 'POST',
                    data: {studyID: $("#studyID").val(),
                          lineID: $("#lineID").val(),
                          lineVariationID: $("#lineVariationID").val(),
                          lineName: $("#lineName").val(),
                          lineText: $("#lineText").val(),
                          linePGN: $("#iframeLine").contents().find("#pgnUpdated").val()},
                    success: function (result) {
                      var response = JSON.parse(result);

    									if(response["status"] == "success"){
                        //mostrar toaster após reload
                        sessionStorage.setItem("Success","Saved changes!");
                        location.reload();
    									}else if(response["status"] == "error"){
    										toastr.warning('Error. Please, try again later.');
    									}
                    }, error: function (result) {
                    		toastr.error('Error. Please, try again later.');
                		}
                });
            });
        });

    $(document).ready(function () {
          $("#btnSaveBibliography").click(function () {
              $.ajax({
                  url: './action/theory-bibliography.php',
                  type: 'POST',
                  data: {studyID: $("#studyID").val(),
                        theoryBibliographyID: $("#theoryBibliographyID").val(),
                        textBibliography: $("#textBibliography").val()},
                  success: function (result) {
                    var response = JSON.parse(result);

  									if(response["status"] == "success"){
  										toastr.success('Saved changes!');
  									}else if(response["status"] == "error"){
  										toastr.warning('Error. Please, try again later.');
  									}
                  }, error: function (result) {
                      toastr.error('Error. Please, try again later.');
                  }
              });
          });
      });

  });
</script>
