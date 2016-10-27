<?
   // #INCLUDES
   require_once ('../../lib/config.php');

   // CONTROLE SESSAO
   fnInicia_Sessao ( 'listboards' );
   include('../../imports/header.php');
   ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<div class="page-content">

	 <? include('../../imports/alert.php'); ?>

   <div class="row">
      <div class="col-md-12">
         <!-- BEGIN PAGE TITLE & BREADCRUMB-->
         <h3 class="page-title">
            Meus diagramas <small></small>
         </h3>
      </div>
   </div>
   <!-- END PAGE HEADER-->

   <!-- BEGIN EXAMPLE TABLE PORTLET-->
   <div class="portlet box yellow">
      <div class="portlet-title">
         <div class="caption">
            <i class="fa fa-user"></i>Table
         </div>
         <div class="actions">
            <a href="javascript:;" class="btn btn-default btn-sm">
            <i class="fa fa-pencil"></i> Add </a>
            <div class="btn-group">
               <a class="btn btn-default btn-sm" href="javascript:;" data-toggle="dropdown">
               <i class="fa fa-cogs"></i> Tools <i class="fa fa-angle-down"></i>
               </a>
               <ul class="dropdown-menu pull-right">
                  <li>
                     <a href="javascript:;">
                     <i class="fa fa-pencil"></i> Edit </a>
                  </li>
                  <li>
                     <a href="javascript:;">
                     <i class="fa fa-trash-o"></i> Delete </a>
                  </li>
                  <li>
                     <a href="javascript:;">
                     <i class="fa fa-ban"></i> Ban </a>
                  </li>
                  <li class="divider">
                  </li>
                  <li>
                     <a href="javascript:;">
                     <i class="i"></i> Make admin </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="portlet-body">
         <table class="table table-striped table-bordered table-hover" id="sample_2">
            <thead>
               <tr>
                  <th class="table-checkbox">
                     <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                  </th>
                  <th>
                     Username
                  </th>
                  <th>
                     Email
                  </th>
                  <th>
                     Status
                  </th>
               </tr>
            </thead>
            <tbody>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     shuxer
                  </td>
                  <td>
                     <a href="mailto:shuxer@gmail.com">
                     shuxer@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     looper
                  </td>
                  <td>
                     <a href="mailto:looper90@gmail.com">
                     looper90@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-warning">
                     Suspended </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     userwow
                  </td>
                  <td>
                     <a href="mailto:userwow@yahoo.com">
                     userwow@yahoo.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     user1wow
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     userwow@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-default">
                     Blocked </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     restest
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     test@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     foopl
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     good@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     weep
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     good@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     coop
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     good@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     pppol
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     good@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     test
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     good@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     userwow
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     userwow@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-default">
                     Blocked </span>
                  </td>
               </tr>
               <tr class="odd gradeX">
                  <td>
                     <input type="checkbox" class="checkboxes" value="1"/>
                  </td>
                  <td>
                     test
                  </td>
                  <td>
                     <a href="mailto:userwow@gmail.com">
                     test@gmail.com </a>
                  </td>
                  <td>
                     <span class="label label-sm label-success">
                     Approved </span>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
   <!-- END EXAMPLE TABLE PORTLET-->

   <!-- END CONTENT -->
</div>
<? include('../../imports/footer.php'); ?>
<? include('../../imports/metronic_core.php'); ?>
<script>
   jQuery(document).ready(function() {
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layou
   TableManaged.init();
   });
</script>
</body>
</html>
