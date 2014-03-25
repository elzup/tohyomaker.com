<?php
/* @var $survey Surveyobj */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="items-div">
			<div class="itembox-div" data-toggle="buttons-radio">
				<ul>
					<?php
					foreach ($survey->items as $item)
					{
						$i = $item->index;
						// btn state define page loaded start view
						$add_class = '';
						if ($survey->state != SURVEY_STATE_PROGRESS || $survey->is_voted())
						{
							$add_class .= ' disabled';
						}
						if ((isset($select) && $i === $select) || $survey->selected === $i)
						{
							$add_class .= ' active';
						}
						$add_class .= (isset($select) && $i == $select) ? ($survey->is_voted() ? ' active' : '' ) : '';
						?>
						<li><button type="button" id="item<?= $i ?>" name="<?= $i ?>" class="btn btn-item btn-lg btn-block btn-default<?= $add_class ?>"><?= $item->value ?></button></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<?php
		if ($survey->state == SURVEY_STATE_PROGRESS && !$survey->is_voted())
		{
			if (!empty($token))
			{
				// is_login
				?>
				<form action="<?= base_url("survey/regist/{$survey->id}") ?>" method="POST">
					<!--div class="col-sm-offset-2 col-sm-6" id="text-div">
						<textarea name="vote-text" id="vote-textarea" rows="3"></textarea>
					</div-->
					<div class="col-sm-offset-2 col-sm-8" id="submit-div">
						<input type="hidden" id="vote-value" name="<?= POST_VALUE_NAME ?>" />
						<input type="hidden" name="token" value="<?= $token ?>" />
						<button type="submit" id="submit-main" class="btn btn-primary btn-lg btn-block btn-success disabled">投票</button>
					</div>
				</form>
				<?php
			} else
			{
				// no login
				// TODO : with use to makeform view structure
				?>
				<div class="col-sm-offset-2 col-sm-8">
					<button type="submit" id="submit-main-disable" class="btn btn-primary btn-lg btn-block btn-success disabled">投票*</button>
					<span class="help-block">*Twitterでログインが必要です. <a <?= attr_href(HREF_TYPE_LOGIN) ?> class="btn btn-info">ログインする</a></span>
				</div>
				<?php
			}
		} else
		{

			if ($survey->state != SURVEY_STATE_PROGRESS)
			{
				// is survey ended
				?>
				<div class="col-sm-offset-2 col-sm-8 well" id="survey-state-end-div">
					<p>この投票は終了しました</p>
					<span class="help-block">*投票先情報は一週間経つと消去されます</span>
				</div>

				<?php
			}
			if ($survey->is_voted())
		{


				$selected_item = $survey->get_selected_item();
				$share_uri = base_url($survey->id);
				$share_text = totext_share($selected_item->value, $survey->title);
				?>
				<div class="col-sm-offset-2 col-sm-8" id="selectend-div">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><?= totext_voted($selected_item->value) ?></h3>
						</div>
						<div class="panel-body">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i>コピペ用</span>
								<input id="share-text" type="text" class="form-control" value="<?= $share_text . ' ' . $share_uri ?>">
								<span class="input-group-btn">
									<!--button id="copy-btn" class="btn btn-default disabled" data-toggle="tooltip" data-placement="top" title="クリップボードにコピー">
										<i class="glyphicon glyphicon-file"></i>
									</button-->
								</span>
							</div>
							<div class="sharebtns-div">
								<p>
									<?php sharebtn_twitter($share_text, $share_uri) ?>
								</p>
							</div>
						</div>
						<div class="panel-footer">
						</div>
					</div>
				</div>
			<?php
			}
		}
		?>
		<!--iframe name="hide-frame" class="no-display"></iframe-->
	</div>
</div>
