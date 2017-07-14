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

  $variationsCount = count($study->variations);

  $line = new Line();
  $arrLines = $line->getAllLinesForStudy($paramStudy);

  $linesCount = count($arrLines);

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
                <li>
                  <a data-toggle="tab" href="#tab_1">
                  <i class="fa fa-birthday-cake"></i> History </a>
                  <span class="after">
                  </span>
                </li>
                <li>
                  <a data-toggle="tab" href="#tab_2">
                  <i class="fa fa-puzzle-piece"></i> Game style </a>
                </li>
                <li>
                  <a data-toggle="tab" href="#tab_3">
                  <i class="fa fa-users"></i> Main Grandmasters </a>
                </li>
                <li>
                  <a data-toggle="tab" href="#tab_4">
                  <i class="fa fa-minus"></i> Variations </a>
                </li>
                <li class="active">
                  <a data-toggle="tab" href="#tab_5">
                  <i class="fa fa-bars"></i> Lines </a>
                </li>
                <li>
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
                    <div id="tab_1" class="tab-pane">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> History</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <textarea id="textarea_history" maxlength="1000" class="wysihtml5 form-control" rows="6" placeholder="E.g: The Caro–Kann is a common defense against the King's Pawn Opening and is classified as a Semi-Open Game like the Sicilian Defence and French Defence, although it is thought to be more solid and less dynamic than either of those openings. It often leads to good endgames for Black, who has the better pawn structure."><?=$study->baseTheory->theoryHistory->text?></textarea>
                          <span class="help-block">
                            <div id="countHistory" class="pull-right"></div>
                          </span>
                          <a href="#" class="btn btn-lg btn-primary" id="btnSaveHistory" title="Save"><i class="fa fa-floppy-o"></i></a>
                        </div>
                      </div>
                    </div>
                    <div id="tab_2" class="tab-pane">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Game Style</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <textarea id="textarea_gamestyle" maxlength="1000" class="wysihtml5 form-control" rows="6" placeholder="E.g: The Caro-Kann Defense is very similar to the French Defense because Black establishes a center Pawn at d5, but there are important differences. First, the Caro-Kann often leads to an open or semi-open center, while the French Defense aims for a closed center. Second, since Black supports the d5 Pawn with the c6 Pawn, either Pawn trade (exd5 by White or … dxe4 by Black) will unbalance the Pawn majorities on both sides, resulting in more dynamic play compared to the French Defense. Third, the French Defense has the inherent problem of developing Black’s QB which is locked in after … e6; in the Caro-Kann, Black typically develops the QB first (to f5 or g4) and then plays … e6, avoiding this situation altogether.
                            Caro-Kann players tend to be solid and sure, which is why I always use the Panov-Botvinnik Attack as White (1. e4 c6 2. d4 d5 3. ed cd 4. c4) with the benefits and drawbacks of an isolated queen`s pawn.">
                                          <?=$study->baseTheory->theoryGameStyle->text?></textarea>
                          <span class="help-block">
                            <div id="countGameStyle" class="pull-right"></div>
                            <a href="#" class="btn btn-lg btn-primary" id="btnSaveGameStyle" title="Save"><i class="fa fa-floppy-o"></i></a>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div id="tab_3" class="tab-pane">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Main Grandmasters</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <textarea id="textarea_maingrandmasters" maxlength="1000" class="wysihtml5 form-control" rows="6" placeholder="E.g: At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culp orem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.">
                                         <?=$study->baseTheory->theoryMainGrandMasters->text?></textarea>
                          <span class="help-block">
                            <div id="countMainGrandMasters" class="pull-right"></div>
                            <a href="#" class="btn btn-lg btn-primary" id="btnSaveMainGrandMasters" title="Save"><i class="fa fa-floppy-o"></i></a>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div id="tab_4" class="tab-pane">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Variations</span>
                          </div>
                          <div class="actions">
                            <a href="modalNewVariation.php" data-target="#modalNewVariation" class="btn btn-lg btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> NEW VARIATION</a>
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
                                <tr href="modalEditVariation.php?s=<?=$study->id?>&v=<?=$variation->id?>" data-target="#modalEditVariation" data-toggle="modal">
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
                      <div id="modalNewVariation" class="modal fade" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          </div>
                        </div>
                      </div>
                      <div id="modalEditVariation" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="tab_5" class="tab-pane active">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Lines</span>
                          </div>
                          <div class="actions">
                            <a href="modalNewLine.php?s=<?=$study->id?>" data-target="#modalNewLine" class="btn btn-lg btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> NEW LINE</a>
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
                                  <tr href="modalEditLine.php?s=<?=$study->id?>&l=<?=$line->id?>" data-target="#modalEditLine" data-toggle="modal">
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
                      <div id="modalNewLine" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          </div>
                        </div>
                      </div>
                      <div id="modalEditLine" class="modal fade bs-modal-lg" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="tab_6" class="tab-pane">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject bold uppercase"> Bibliography</span>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <textarea id="textarea_bibliography" maxlength="10" class="wysihtml5 form-control" rows="6"><?=$study->baseTheory->theoryBibliography->text?></textarea>
                          <span class="help-block">
                            <div id="countBibliography" class="pull-right"></div>
                            <a href="#" class="btn btn-lg btn-primary" id="btnSaveBibliography" title="Save"><i class="fa fa-floppy-o"></i></a>
                          </span>
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

   //  ComponentsEditors.init();

    $('#textarea_history').wysihtml5({
         events: {
           load: function() {
             var editor = this;
             $(editor.currentView.doc.body).on("keydown",function(event) {
               var l = event.currentTarget.innerText.length;
               if(l > 1000) {
                 var left = 1000 - l;
                 $('#countHistory').html('<span class="label label-danger">'+ left + ' / 1000' +'</span>');
                 $('#btnSaveHistory').hide();
               } else {
                 var left = 1000 - l;
                 $('#countHistory').html('<span class="label label-success">'+ left + ' / 1000' +'</span>');
                 $('#btnSaveHistory').show();
               }
             });
           }
         }
      });

      $('#textarea_gamestyle').wysihtml5({
           events: {
             load: function() {
               var editor = this;
               $(editor.currentView.doc.body).on("keydown",function(event) {
                 var l = event.currentTarget.innerText.length;
                 if(l > 1000) {
                   var left = 1000 - l;
                   $('#countGameStyle').html('<span class="label label-danger">'+ left + ' / 1000' +'</span>');
                   $('#btnSaveGameStyle').hide();
                 } else {
                   var left = 1000 - l;
                   $('#countGameStyle').html('<span class="label label-success">'+ left + ' / 1000' +'</span>');
                   $('#btnSaveGameStyle').show();
                 }
               });
             }
           }
        });

        $('#textarea_maingrandmasters').wysihtml5({
             events: {
               load: function() {
                 var editor = this;
                 $(editor.currentView.doc.body).on("keydown",function(event) {
                   var l = event.currentTarget.innerText.length;
                   if(l > 1000) {
                     var left = 1000 - l;
                     $('#countMainGrandMasters').html('<span class="label label-danger">'+ left + ' / 1000' +'</span>');
                     $('#btnSaveMainGrandMasters').hide();
                   } else {
                     var left = 1000 - l;
                     $('#countMainGrandMasters').html('<span class="label label-success">'+ left + ' / 1000' +'</span>');
                     $('#btnSaveMainGrandMasters').show();
                   }
                 });
               }
             }
          });

          $('#textarea_bibliography').wysihtml5({
               events: {
                 load: function() {
                   var editor = this;
                   $(editor.currentView.doc.body).on("keydown",function(event) {
                     var l = event.currentTarget.innerText.length;
                     if(l > 1000) {
                       var left = 1000 - l;
                       $('#countBibliography').html('<span class="label label-danger">'+ left + ' / 1000' +'</span>');
                       $('#btnSaveBibliography').hide();
                     } else {
                       var left = 1000 - l;
                       $('#countBibliography').html('<span class="label label-success">'+ left + ' / 1000' +'</span>');
                       $('#btnSaveBibliography').show();
                     }
                   });
                 }
               }
            });
  });
</script>
