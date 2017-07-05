<?php
require_once('../models/Variation.php');

$paramStudy = $_GET['s'];
// $paramLine = $_GET['l'];

$variation = new Variation();
$arrVariations = $variation->getAllVariationsForStudy($paramStudy);
// $line = new Line ();
// $line = $line->getLineWithID($paramLine);

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h4 class="modal-title">Opening Line</h4>
</div>
<div class="modal-body form">
  <form action="#" class="form-horizontal form-row-seperated">
    <div class="form-group">
      <div class="col-sm-4">
        <label class="control-label">Variation parent</label>
        <div class="input-group">
          <span class="input-group-addon">
          <i class="fa fa-minus"></i>
          </span>
          <select class="form-control select2me" name="variationNewLine">
            <option value="">Select...</option>
            <?php foreach ($arrVariations as $key => $variation): ?>
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
          <input type="text" id="nameNewLine" placeholder="E.g: Alekhine variation" name="nameNewLine" class="form-control"/>
        </div>
      </div>
      <div class="col-sm-4">
        <label class="control-label">Description</label> <small>(Max: 1000 chars)</small>
        <div class="input-group">
          <span class="input-group-addon">
          <i class="fa fa-info"></i>
          </span>
          <input type="text" id="typeahead_example_modal_1" placeholder="E.g: Black tempts White's pawns forward to form a broad pawn centre." name="descriptionNewLine" class="form-control" onkeyup="countChar(this)" maxlength="1000"/>
        </div>
      </div>
    </div>
    <div class="form-group last">
      <div class="col-sm-12">
        <div class="input-group">
          <span style="visibility:hidden" class="input-group-addon"></span>
          <div class="portlet-body">
            <iframe name='iframe1' id="iframe1" onload="resizeIframe(this)" src="../board/pgneditor.php" scrolling="yes"
              frameborder="0" border="0" cellspacing="0"
              style="border-style: none;width: 100%; height: 610px;"></iframe>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
  <button type="button" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
</div>
<script>
jQuery(document).ready(function() {
  // initiate layout and plugins
  Metronic.init(); // init metronic core components
});
function countChar(val) {
        var len = val.value.length;
        if (len >= 1000) {
          val.value = val.value.substring(0, 1000);
        }
};
</script>
