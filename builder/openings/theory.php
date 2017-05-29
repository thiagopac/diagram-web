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
            <a href="./">Openings</a>
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
      <div class="page-toolbar">
        <div class="btn-group pull-right">
          <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
          Actions <i class="fa fa-angle-down"></i>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>
              <a href="#">Restart stats</a>
            </li>
            <li>
              <a href="#">Tell a friend</a>
            </li>
            <li class="divider">
            </li>
            <li>
              <a href="#">Back to start</a>
            </li>
          </ul>
        </div>
      </div>
   </div>
   <!-- END PAGE TITLE & BREADCRUMB-->
   <? include('../imports/alert.php'); ?>
   <div class="progress">
     <div class="progress-bar blue-hoki" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
       <span>
       85% Complete </span>
     </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <!-- BEGIN TODO SIDEBAR -->
         <div class="todo-ui">
            <div class="todo-sidebar">
               <div class="portlet light">
                  <div class="portlet-title">
                     <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                        <span class="caption-subject font-green-sharp bold uppercase">LEARNING </span>
                     </div>
                     <div class="actions">
                        <div class="btn-group">
                           <a class="btn green-haze btn-circle btn-sm todo-projects-config" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                           <i class="icon-settings"></i> &nbsp; <i class="fa fa-angle-down"></i>
                           </a>
                           <ul class="dropdown-menu pull-right">
                              <li>
                                 <a href="javascript:;">
                                 <i class="i"></i> Relatar um erro </a>
                              </li>
                              <li>
                                 <a href="javascript:;">
                                 Novidades do autor <span class="badge badge-danger">
                                 4 </span>
                                 </a>
                              </li>
                              <li class="divider">
                              </li>
                              <li>
                                 <a href="javascript:;">
                                 <i class="i"></i> Finalizar treinamento </a>
                              </li>
                           </ul>
                        </div>
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
                           <i class="fa fa-puzzle-piece"></i> Game Style </a>
                        </li>
                        <li>
                           <a data-toggle="tab" href="#tab_3">
                           <i class="fa fa-users"></i> Main Grandmasters </a>
                        </li>
                        <li class="active">
                           <a data-toggle="tab" href="#tab_4">
                           <i class="fa fa-bars"></i> Variations </a>
                        </li>
                        <li>
                           <a data-toggle="tab" href="#tab_5">
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
                                       <div class="actions">
                                          <div class="btn-group">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox-history" class="md-check" >
                                                <label for="checkbox-history">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Mark as learned </label>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div>
                                          <p>
                                             At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culp orem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.
                                          </p>
                                          <blockquote class="hero">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere erat a ante.
                                             </p>
                                             <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                                          </blockquote>
                                          <p>
                                             At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique dimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_2" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> Game Style</span>
                                       </div>
                                       <div class="actions">
                                          <div class="btn-group">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox-game-style" class="md-check" >
                                                <label for="checkbox-game-style">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Mark as learned </label>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div>
                                          <p>
                                             At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culp orem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.
                                          </p>
                                          <blockquote class="hero">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere erat a ante.
                                             </p>
                                             <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                                          </blockquote>
                                          <p>
                                             At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique dimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_3" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> Main Grandmasters</span>
                                       </div>
                                       <div class="actions">
                                          <div class="btn-group">
                                             <div class="md-checkbox">
                                                <input type="checkbox" id="checkbox-main-players" class="md-check" >
                                                <label for="checkbox-main-players">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Mark as learned </label>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div>
                                          <p>
                                             At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culp orem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.
                                          </p>
                                          <blockquote class="hero">
                                             <p>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit posuere erat a ante.
                                             </p>
                                             <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                                          </blockquote>
                                          <p>
                                             At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique dimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_4" class="tab-pane active">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> Linhas</span>
                                       </div>
                                       <div class="actions">
                         								<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                         								</a>
                         							</div>
                                    </div>
                                    <div class="portlet-body">
                                      <div class="row">

                                          <ul class="nav nav-tabs">
                                            <li class="active">
                                              <a href="#tab_1_1" data-toggle="tab">
                                              Variante Clássica </a>
                                            </li>
                                            <li class="dropdown">
                                              <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                              Ataque Panov <i class="fa fa-angle-down"></i>
                                              </a>
                                              <ul class="dropdown-menu" role="menu">
                                                <li>
                                                  <a href="#tab_2_1" tabindex="-1" data-toggle="tab">
                                                  Panov 1 </a>
                                                </li>
                                                <li>
                                                  <a href="#tab_2_2" tabindex="-1" data-toggle="tab">
                                                  Panov 2 </a>
                                                </li>
                                                <li>
                                                  <a href="#tab_2_3" tabindex="-1" data-toggle="tab">
                                                  Panov 3 </a>
                                                </li>
                                                <li>
                                                  <a href="#tab_2_4" tabindex="-1" data-toggle="tab">
                                                  Panov 4 </a>
                                                </li>
                                              </ul>
                                            </li>
                                            <li>
                                              <a href="#tab_3_1" data-toggle="tab">
                                              Variante das Trocas </a>
                                            </li>
                                            <li>
                                              <a href="#tab_4_1" data-toggle="tab">
                                              Variante Smyslov </a>
                                            </li>
                                          </ul>


                                          <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1_1">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Variante Clássica</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-classica" class="md-check" >
                                                             <label for="checkbox-variante-classica">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                       <iframe name='iframe1' id="iframe1" onload="resizeIframe(this)" src="../board/pgnviewer.php" scrolling="yes"
                                                        frameborder="0" border="0" cellspacing="0"
                                                        style="border-style: none;width: 100%; height: 600px;"></iframe>
                                                 </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_2_1">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Panov 1</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-panov-1" class="md-check" >
                                                             <label for="checkbox-variante-panov-1">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                    <div>
                                                       Tabuleiro
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_2_2">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Panov 2</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-panov-2" class="md-check" >
                                                             <label for="checkbox-variante-panov-2">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                    <div>
                                                       Tabuleiro
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_2_3">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Panov 3</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-panov-3" class="md-check" >
                                                             <label for="checkbox-variante-panov-3">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                    <div>
                                                       Tabuleiro
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_2_4">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Panov 4</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-panov-4" class="md-check" >
                                                             <label for="checkbox-variante-panov-4">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                    <div>
                                                       Tabuleiro
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_3_1">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Variante das Trocas</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-das-trocas" class="md-check" >
                                                             <label for="checkbox-variante-das-trocas">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                    <div>
                                                       Tabuleiro
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_4_1">
                                              <div class="portlet light">
                                                 <div class="portlet-title">
                                                    <div class="caption">
                                                       <span class="caption-subject uppercase"> Variante Smyslov</span>
                                                    </div>
                                                    <div class="actions">
                                                       <div class="btn-group">
                                                          <div class="md-checkbox">
                                                             <input type="checkbox" id="checkbox-variante-smyslov" class="md-check" >
                                                             <label for="checkbox-variante-smyslov">
                                                             <span></span>
                                                             <span class="check"></span>
                                                             <span class="box"></span>
                                                             Mark as learned </label>
                                                          </div>
                                                       </div>
                                                    </div>
                                                 </div>
                                                 <div class="portlet-body">
                                                    <div>
                                                       Tabuleiro
                                                    </div>
                                                 </div>
                                              </div>
                                            </div>
                                          </div>

                                      </div>
                                    </div>
                                 </div>
                              </div>
                              <div id="tab_5" class="tab-pane">
                                 <div class="portlet light">
                                    <div class="portlet-title">
                                       <div class="caption">
                                          <span class="caption-subject bold uppercase"> Bibliography</span>
                                       </div>
                                    </div>
                                    <div class="portlet-body">
                                       <div class="blog-twitter">
                                          <div class="blog-twitter-block">
                                             <p>
                                                BOOK NAME
                                             </p>
                                             <p>
                                                LASTNAME, Author Name
                                             </p>
                                             <a href="javascript:;">
                                             <em>http://google.com.br</em>
                                             </a>
                                             <i class="fa fa-info blog-twiiter-icon"></i>
                                          </div>
                                          <div class="blog-twitter-block">
                                             <p>
                                                BOOK NAME
                                             </p>
                                             <p>
                                                LASTNAME, Author Name
                                             </p>
                                             <a href="javascript:;">
                                             <em>http://google.com.br</em>
                                             </a>
                                             <i class="fa fa-info blog-twiiter-icon"></i>
                                          </div>
                                          <div class="blog-twitter-block">
                                             <p>
                                                BOOK NAME
                                             </p>
                                             <p>
                                                LASTNAME, Author Name
                                             </p>
                                             <a href="javascript:;">
                                             <em>http://google.com.br</em>
                                             </a>
                                             <i class="fa fa-info blog-twiiter-icon"></i>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
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

   });
</script>
