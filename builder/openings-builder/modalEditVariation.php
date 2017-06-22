<?php
require_once('../models/Variation.php');
$paramVariation = $_GET['v'];

$variation = new Variation ();
$variation = $variation->getVariationWithID($paramVariation);

?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Opening Variation</h4>
  </div>
  <div class="modal-body form">
    <form action="#" class="form-horizontal form-row-seperated">
      <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
            <i class="fa fa-tag"></i>
            </span>
            <input type="text" id="nameEditVariation" name="nameEditVariation" class="form-control" value="<?=$variation->name?>"/>
          </div>
          <p class="help-block">
            E.g: Advanced Variation<br>
          </p>
        </div>
      </div>
      <div class="form-group last">
        <label class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
            <i class="fa fa-info"></i>
            </span>
            <textarea class="form-control" rows="4" id="textarea_description" onkeyup="countChar(this)" maxlength="1000"><?=$variation->text?></textarea>
          </div>
          <p class="help-block">
            Max: 1000 chars<br>
          </p>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
    <button type="button" class="btn btn purple" title="Delete" data-dismiss="modal"><i class="fa fa-trash-o"></i></button>
    <button type="button" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
  </div>
</div>
<script>
function countChar(val) {
        var len = val.value.length;
        if (len >= 1000) {
          val.value = val.value.substring(0, 1000);
        }
};
</script>
