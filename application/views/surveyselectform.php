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
						$onload = '';
						if (isset($select) && $i == $select)
						{
							$onload = ' onload="this.click()"';
						}
						?>
						<li><button type="button" id="item<?= $i ?>" name="<?= $i ?>" class="btn btn-item btn-lg btn-block btn-default"<?= $onload ?>><?= $item ?></button></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<form action="<?= base_url("survey/regist") ?>" method="POST">
			<!--div class="col-sm-offset-2 col-sm-6" id="text-div">
				<textarea name="vote-text" id="vote-textarea" rows="3"></textarea>
			</div-->
			<div class="col-sm-offset-2 col-sm-8" id="submit-div">
				<input type="hidden" id="vote-value" name="vote-value" />
				<input type="hidden" name="token" value="<?= $token ?>" />
				<button type="submit" class="btn btn-primary btn-lg btn-block btn-default">投票</button>
			</div>
		</form>
	</div>
</div>
