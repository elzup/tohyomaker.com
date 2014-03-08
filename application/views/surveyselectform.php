<?php
/**
 * @var $survey SurveyObj
 * @var $token string
 * @var $select int
 */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="items-div">
			<div class="itembox-div" data-toggle="buttons-radio">
				<ul>
					<?php
					foreach ($survey->items as $i => $item)
					{
						$selected = '';
						if (isset($select) && $i == $select)
						{
							$selected = ' active';
						}
						?>
						<li><button type="button" id="item<?= $i ?>" name="<?= $i ?>" class="btn btn-item btn-lg btn-block btn-default<?= $selected ?>"><?= $item ?></button></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<form target="hide-frame" action="<?= base_url("survey/regist") ?>" method="POST">
			<!--div class="col-sm-offset-2 col-sm-6" id="text-div">
				<textarea name="vote-text" id="vote-textarea" rows="3"></textarea>
			</div-->
			<div class="col-sm-offset-2 col-sm-8" id="submit-div">
				<input type="hidden" id="vote-value" name="vote-value" />
				<input type="hidden" name="token" value="<?= $token ?>" />
				<button type="submit" id="submit-main" class="btn btn-primary btn-lg btn-block btn-default disabled">投票</button>
			</div>
		</form>
		<iframe name="hide-frame" class="no-display"></iframe>
	</div>
</div>
