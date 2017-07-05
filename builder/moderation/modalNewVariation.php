<?php
require_once('../models/Variation.php');
// $paramVariation = $_GET['v'];
//
// $variation = new Variation ();
// $variation = $variation->getVariationWithID($paramVariation);

$eco = new Eco();
$arrEcos = $eco->getALlEcos();

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h4 class="modal-title">Opening Variation</h4>
</div>
<div class="modal-body form">
  <form action="#" class="form-horizontal">
    <div class="form-body">
    <div class="form-group">
      <label class="col-md-3 control-label">Name</label>
      <div class="col-md-6">
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

    <div class="form-group">
      <label class="col-md-3 control-label">ECO Opening</label>
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-addon">
          <i class="fa fa-tag"></i>
          </span>
          <select class="form-control select2me" name="ecoCode">
             <option value="">Select...</option>
             <?php foreach ($arrEcos as $key => $eco): ?>

               <option value="<?=$eco->id?>">[<?=$eco->code?>] - <?=$eco->name?> (<?=$eco->line?>)</option>
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
          <textarea class="form-control" rows="4" id="textarea_description" onkeyup="countChar(this)" maxlength="1000"></textarea>
        </div>
        <p class="help-block">
          Max: 1000 chars<br>
        </p>
      </div>
    </div>
  </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" title="Cancel" data-dismiss="modal"><i class="fa fa-close"></i></button>
  <button type="button" class="btn btn-primary" title="Save" data-dismiss="modal"><i class="fa fa-floppy-o"></i></button>
</div>
</div>
<script>
jQuery(document).ready(function() {
  // initiate layout and plugins
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layou

  });

function countChar(val) {
        var len = val.value.length;
        if (len >= 1000) {
          val.value = val.value.substring(0, 1000);
        }
};
</script>
