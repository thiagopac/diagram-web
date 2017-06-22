<?php
require_once('../models/Variation.php');
require_once('../models/Line.php');

$paramStudy = $_GET['s'];
$paramLine = $_GET['l'];
$paramPracticeLine = $_GET['pl'];

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h4 class="modal-title"><?php $paramPracticeLine == null ? $title = "Add new Practice Line" : $title = "Edit Practice Line" ?> <?=$title ?></h4>
</div>
<div class="modal-body form">
  <form action="#" class="form-horizontal form-row-seperated">
    <div class="form-group">
      <div class="col-md-12">
        <div class="portlet-body">
          <iframe name='iframe1' id="iframe1" onload="resizeIframe(this)" src="../board/practiceeditor.php?pl=<?=$paramPracticeLine?>" scrolling="yes"
            frameborder="0" border="0" cellspacing="0"
            style="border-style: none;width: 100%; height: 400px;"></iframe>
        </div>
        <span class="badge badge-roundless badge-danger">NOTE</span>
        <small>To use an external PGN, paste it into the text field, then click the <i class="fa fa-pencil-square-o"></i> button.</small>
      </div>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
  <button type="button" class="btn btn purple" title="Delete" data-dismiss="modal"><i class="fa fa-trash-o"></i></button>
  <button type="button" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
</div>
<script>

</script>
