<?
   // #INCLUDES
   require_once ('../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'openings' );
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
            <a href="./">Openings Builder</a>
            <i class="fa fa-angle-right"></i>
         </li>
         <li>
            <a href="details.php">Caro-Kann</a>
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
                        <li class="active">
                           <a data-toggle="tab" href="#tab_4">
                           <i class="fa fa-minus"></i> Variations </a>
                        </li>
                        <li>
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
                        <span class="caption-helper">OPENING:</span> &nbsp; <span class="caption-subject font-green-sharp bold uppercase">Caro-Kann Defense</span>
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
                                       <textarea id="textarea_history" maxlength="1000" class="form-control" rows="6" placeholder="E.g: The Caro–Kann is a common defense against the King's Pawn Opening and is classified as a Semi-Open Game like the Sicilian Defence and French Defence, although it is thought to be more solid and less dynamic than either of those openings. It often leads to good endgames for Black, who has the better pawn structure."></textarea>
                                       <span class="help-block">
                                       <a href="#" class="btn btn-lg btn-primary" title="Save"><i class="fa fa-floppy-o"></i></a>
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
                                       <textarea id="textarea_gamestyle" maxlength="1000" class="form-control" rows="6" placeholder="E.g: The Caro-Kann Defense is very similar to the French Defense because Black establishes a center Pawn at d5, but there are important differences. First, the Caro-Kann often leads to an open or semi-open center, while the French Defense aims for a closed center. Second, since Black supports the d5 Pawn with the c6 Pawn, either Pawn trade (exd5 by White or … dxe4 by Black) will unbalance the Pawn majorities on both sides, resulting in more dynamic play compared to the French Defense. Third, the French Defense has the inherent problem of developing Black’s QB which is locked in after … e6; in the Caro-Kann, Black typically develops the QB first (to f5 or g4) and then plays … e6, avoiding this situation altogether.
                                          Caro-Kann players tend to be solid and sure, which is why I always use the Panov-Botvinnik Attack as White (1. e4 c6 2. d4 d5 3. ed cd 4. c4) with the benefits and drawbacks of an isolated queen`s pawn."></textarea>
                                       <span class="help-block">
                                       <a href="#" class="btn btn-lg btn-primary" title="Save"><i class="fa fa-floppy-o"></i></a>
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
                                       <textarea id="textarea_maingrandmasters" maxlength="1000" class="form-control" rows="6" placeholder="E.g: At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culp orem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus."></textarea>
                                       <span class="help-block">
                                       <a href="#" class="btn btn-lg btn-primary" title="Save"><i class="fa fa-floppy-o"></i></a>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_4" class="tab-pane active">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> Variations</span>
                                       </div>
                                       <div class="actions">
                                         <a href="#modalNewVariation" class="btn btn-lg btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> NEW VARIATION</a>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <small>This study does not have any line yet.</small>
                                    </div>
                                 </div>
                                 <div id="modalNewVariation" class="modal fade" role="dialog" aria-hidden="true">
                                   <div class="modal-dialog">
                                     <div class="modal-content">
                                       <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                         <h4 class="modal-title">Opening Variation</h4>
                                       </div>
                                       <div class="modal-body form">
                                         <form action="#" class="form-horizontal form-row-seperated">
                                           <div class="form-group">
                                             <label class="col-sm-4 control-label">Name</label>
                                             <div class="col-sm-8">
                                               <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-tag"></i>
                                                 </span>
                                                 <input type="text" id="typeahead_example_modal_1" name="typeahead_example_modal_1" class="form-control"/>
                                               </div>
                                               <p class="help-block">
                                                  E.g: Advanced Variation<br>
                                               </p>
                                             </div>
                                           </div>
                                           <div class="form-group">
                                             <label class="col-sm-4 control-label">Description</label>
                                             <div class="col-sm-8">
                                               <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-info"></i>
                                                 </span>
                                                 <textarea class="form-control" rows="2"></textarea>
                                               </div>
                                             </div>
                                           </div>
                                           <div class="form-group last">
                                             <label class="col-sm-4 control-label">Primary language</label>
                                             <div class="col-sm-8">
                                               <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-language"></i>
                                                 </span>
                                                 <select class="form-control select2me" name="options2">
                                                    <option value="">Select...</option>
                                                    <option value="Option 1">Option 1</option>
                                                    <option value="Option 2">Option 2</option>
                                                    <option value="Option 3">Option 3</option>
                                                    <option value="Option 4">Option 4</option>
                                                 </select>
                                               </div>
                                             </div>
                                           </div>
                                         </form>
                                       </div>
                                       <div class="modal-footer">
                                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                         <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
                                       </div>
                                     </div>
                                   </div>
                                 </div>

                              </div>
                              <div id="tab_5" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> Lines</span>
                                       </div>
                                       <div class="actions">
                                         <a href="#modalNewLine" class="btn btn-lg btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> NEW LINE</a>
                                          <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <small>This study does not have any line yet.</small>
                                    </div>
                                 </div>
                                 <div id="modalNewLine" class="modal fade" role="dialog" aria-hidden="true">
                                   <div class="modal-dialog">
                                     <div class="modal-content">
                                       <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                         <h4 class="modal-title">Opening Line</h4>
                                       </div>
                                       <div class="modal-body form">
                                         <form action="#" class="form-horizontal form-row-seperated">
                                           <div class="form-group">
                                             <label class="col-sm-4 control-label">Name</label>
                                             <div class="col-sm-8">
                                               <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-tag"></i>
                                                 </span>
                                                 <input type="text" id="typeahead_example_modal_1" name="typeahead_example_modal_1" class="form-control"/>
                                               </div>
                                               <p class="help-block">
                                                  E.g: Advanced Variation<br>
                                               </p>
                                             </div>
                                           </div>
                                           <div class="form-group">
                                             <label class="col-sm-4 control-label">Description</label>
                                             <div class="col-sm-8">
                                               <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-info"></i>
                                                 </span>
                                                 <textarea class="form-control" rows="2"></textarea>
                                               </div>
                                             </div>
                                           </div>
                                           <div class="form-group last">
                                             <label class="col-sm-4 control-label">Primary language</label>
                                             <div class="col-sm-8">
                                               <div class="input-group">
                                                 <span class="input-group-addon">
                                                 <i class="fa fa-language"></i>
                                                 </span>
                                                 <select class="form-control select2me" name="options2">
                                                    <option value="">Select...</option>
                                                    <option value="Option 1">Option 1</option>
                                                    <option value="Option 2">Option 2</option>
                                                    <option value="Option 3">Option 3</option>
                                                    <option value="Option 4">Option 4</option>
                                                 </select>
                                               </div>
                                             </div>
                                           </div>
                                         </form>
                                       </div>
                                       <div class="modal-footer">
                                         <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i></button>
                                         <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
                                       </div>
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
                                       <form class="repeater">
                                          <!--
                                             The value given to the data-repeater-list attribute will be used as the
                                             base of rewritten name attributes.  In this example, the first
                                             data-repeater-item's name attribute would become group-a[0][text-input],
                                             and the second data-repeater-item would become group-a[1][text-input]
                                             -->
                                          <div data-repeater-list="group-a">
                                             <div data-repeater-item>
                                                <div class="panel panel-default">
                                                   <div class="panel-heading">
                                                      <div class="caption">
                                                         Bibiography registry
                                                      </div>
                                                   </div>
                                                   <div class="panel-body">
                                                      <div class="form-group">
                                                         <label class="col-md-3 control-label">Name of Book</label>
                                                         <div class="col-md-9">
                                                            <input type="text" class="form-control" id="text_bookname" placeholder="Winning Chess Openings">
                                                            <span class="help-block"></span>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <label class="col-md-3 control-label">Author</label>
                                                         <div class="col-md-9">
                                                            <input type="text" class="form-control" id="text_authorname" placeholder="Yasser Seirawan">
                                                            <span class="help-block"></span>
                                                         </div>
                                                      </div>
                                                      <div class="form-group">
                                                         <label class="col-md-3 control-label">Link</label>
                                                         <div class="col-md-9">
                                                            <input type="text" class="form-control" id="text_booklink" placeholder="http://book-publisher.com/book-info">
                                                            <span class="help-block"></span>
                                                         </div>
                                                      </div>
                                                      <a href="#" class="btn btn-sm btn-danger" title="Remove this registry" data-repeater-delete> Remove</a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <a href="#" class="btn btn-lg btn-success pull-right" title="Add new registry" data-repeater-create><i class="fa fa-plus"></i></a>
                                       </form>
                                    </div>
                                 </div>
                                 <a href="#" class="btn btn-lg btn-primary" title="Save"><i class="fa fa-floppy-o"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="finishedLine" tabindex="-1" role="basic" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title">Title</h4>
                           </div>
                           <div class="modal-body">
                              Body
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn default" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="lineinexistent" tabindex="-1" role="basic" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h4 class="modal-title">Title</h4>
                           </div>
                           <div class="modal-body">
                              Body
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn default" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <audio id="soundMove" src="../../assets/admin/custom/sounds/move.wav" type="audio/wav"></audio>
                  <audio id="soundTake" src="../../assets/admin/custom/sounds/take.wav" type="audio/wav"></audio>
                  <audio id="soundCheck" src="../../assets/admin/custom/sounds/check.wav" type="audio/wav"></audio>
                  <audio id="soundSuccess" src="../../assets/admin/custom/sounds/success.wav" type="audio/wav"></audio>
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
<script src="../../assets/admin/custom/scripts/chess.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="../../assets/admin/custom/scripts/chessboard-0.3.0.js"></script>
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

     var ComponentsFormTools = function () {

         var handleBootstrapMaxlength = function() {

             $('#textarea_history').maxlength({
                 limitReachedClass: "label label-danger",
                 alwaysShow: true,
                 placement: 'bottom-right'
             });

             $('#textarea_gamestyle').maxlength({
                 limitReachedClass: "label label-danger",
                 alwaysShow: true,
                 placement: 'bottom-right'
             });

             $('#textarea_maingrandmasters').maxlength({
                 limitReachedClass: "label label-danger",
                 alwaysShow: true,
                 placement: 'bottom-right'
             });
         }

         handleBootstrapMaxlength();

     }();

     $('.repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': ''
            },
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: false
        })

   });
</script>
