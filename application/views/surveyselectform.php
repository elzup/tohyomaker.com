<?php
/**
 * @var $survey SurveyObj
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
						$selected = (isset($select) && $i == $select) ? ' active' : '';
						$selected .= (($is_voted) ? ' disabled' : '');
						?>
						<li><button type="button" id="item<?= $i ?>" name="<?= $i ?>" class="btn btn-item btn-lg btn-block btn-default<?= $selected ?>"><?= $item ?></button></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<?php
		$hide = (!$is_voted ? '' : ' style="display: none"');
		?>
		<form target="hide-frame" action="<?= base_url("survey/regist/{$survey->id}") ?>" method="POST"<?= $hide ?>>
			<!--div class="col-sm-offset-2 col-sm-6" id="text-div">
				<textarea name="vote-text" id="vote-textarea" rows="3"></textarea>
			</div-->
			<div class="col-sm-offset-2 col-sm-8" id="submit-div">
				<input type="hidden" id="vote-value" name="vote-value" />
				<input type="hidden" name="token" value="<?= $token ?>" />
				<button type="submit" id="submit-main" class="btn btn-primary btn-lg btn-block btn-default disabled">投票</button>
			</div>
		</form>
		<?php
		$hide2 = ($is_voted ? '' : ' style="display: none"');
		?>
		<div class="col-sm-offset-2 col-sm-8" id="voteend-div"<?= $hide2 ?>>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?= totext_voted($survey->items[$select])?></h3>
				</div>
				<div class="panel-body">
					<div class="input-group">
						<!--span class="input-group-addon">#</span-->
						<input type="text" class="form-control" value="<?= totext_share($survey->items[$select], $survey->title, base_url($survey->id))?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" title="" data-original-title="クリップボードにコピー"><i class="glyphicon glyphicon-file"></i></button>
						</span>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
		<iframe name="hide-frame" class=""></iframe>
	</div>
</div>
