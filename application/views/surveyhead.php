<?php
/* @var $survey Surveyobj */
/* @var $owner Userobj */
/* @var $type int */
?>

<div class="container" id="survey-head-div">
	<div class="well">
		<!--div class="row">
			<div class="survey-title" class="col-sm-8">
				<h1><?= $survey->title ?></h1>
			</div>
			<div class ="col-sm-2" class="pagetype">投票ページ</div>
		</div-->

		<div class="row">
			<div class="col-sm-7">
				<?php
				if (isset($survey->description))
				{
					?>
					<div class="row">
						<div class="col-sm-12 survey-cont description">

							<p><?= tag_icon(ICON_DESCRIPTION, isset($survey->description)) . (($survey->description) ? : NO_PARAM_STR) ?></p>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-6 survey-cont timestamp">
						<?= tag_icon(ICON_TIME, TRUE) ?>
						<?= $survey->get_time() ?>
					</div>
					<div class="col-sm-6 owner-name">
						<p>
							<?php
							if (!$survey->is_anonymous)
							{
								?>
								<a <?= attr_href(HREF_TYPE_USER, $survey->owner->id) ?> class="btn btn-success btn-owner-name" <?= attr_tooltip("作者: {$survey->owner->screen_name}") ?> >
									<?= tag_icon(ICON_USER) ?>@<?= $survey->owner->screen_name ?>
								</a>
								<?php
							} else
							{
								?>
								<a href="#" class="btn btn-default btn-owner-name " <?= attr_tooltip("作者非公開") ?>>
									<?= tag_icon(ICON_USER) ?><?= NO_PARAM_STR ?>
								</a>
								<?php
							}
							?>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8 survey-cont tagbox">
				<p class="btn-group-tags">
					<?= tag_icon(ICON_TAG, TRUE) ?>
					<?php
					foreach ($survey->tags as $tag)
					{
						?>
						<a <?= attr_href(HREF_TYPE_TAG, $tag) ?> class="btn btn-success btn-tag btn-xs"><?= $tag ?></a>
					<?php } ?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-7 survey-cont" >
				<?php
				if ($survey->state != SURVEY_STATE_END)
				{
					?>
					<div class="col-sm-3 no-container" <?= attr_tooltip('集計まで残り時間')?>>
						<?= tag_icon(ICON_FLAG, TRUE) ?>
						<?= $survey->get_time_remain_str() ?>
					</div>
					<?php
					$stylelib = explode(',', 'success,end,end');
					$pbstyle = $stylelib[$survey->state];
					?>
					<div class="col-sm-9">
						<div class="progress">
							<div class="progress-bar progress-bar-<?= $pbstyle ?>" style="width: <?= $survey->get_time_progress_par() ?>%;"></div>
						</div>
					</div>
					<?php
				} else
				{
				// TODO: result type 
					?>

					<?php
				}
				?>
			</div>
			<!--div class="col-sm-3 survey-cont">
			<?= tag_icon(ICON_VOTE, TRUE) ?>
				<span class="total-num"><?= $survey->total_num ?></span>
			</div-->
			<div class="col-sm-2 col-sm-offset-3 survey-cont">
				<?php
				$share_uri = base_url(PATH_VOTE . $survey->id);
				$share_text = totext_share_survey($survey);
				echo sharebtn_twitter($share_text, $share_uri);
				?>
			</div>
		</div>
	</div>

	<div class="row" id="survey-pager-div">

		<div class="col-sm-12 col-sm-offset-0">
			<div class="btn-group btn-group-justified">
				<a <?= attr_href(HREF_TYPE_VOTE, $survey->id) ?> class="btn btn-success<?= (($type === SURVEY_PAGETYPE_VOTE) ? ' disabled' : '') ?>">
					<i class="<?= ICON_VOTE ?>"></i>
					投票ページ
				</a>
				<a <?= attr_href(HREF_TYPE_VIEW, $survey->id) ?> class="btn btn-success<?= (($type === SURVEY_PAGETYPE_VIEW) ? ' disabled' : '') ?>">
					<i class="<?= ICON_RESULT ?>"></i>
					結果ページ
				</a>
				<!--TODO: friend's vote page-->
				<a <?= attr_href(HREF_TYPE_VOTE, $survey->id) ?> class="btn btn-success<?= ((TRUE) ? ' disabled' : '') ?>">
					<i class="<?= ICON_FRIEND ?>"></i>
					フレンドの投票先[準備中]
				</a>
			</div>
		</div>
	</div>
</div>