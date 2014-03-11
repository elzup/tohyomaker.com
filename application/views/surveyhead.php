<?php
/* @var $survey SurveyObj */
/* @var $owner UserObj */
/* @var $type int */
?>
<!--TODO: add tooltips, created_time_stamp owner_name-->

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
							<i class="glyphicon glyphicon-comment"></i><?= $survey->description ?>
						</div>
					</div>
				<?php } ?>
				<?php
				if (isset($survey->target))
				{
					?>
					<div class="row">
						<div class="col-sm-12 survey-cont target">
							<i class="glyphicon glyphicon-flag"></i><?= $survey->target ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-6 survey-cont timestamp"><i class="glyphicon glyphicon-time"></i><?= $survey->get_time() ?></div>
					<div class="col-sm-6 owner-name">
						<p>
							<a href="<?= base_url("user/{$survey->owner->id}") ?>" class="btn btn-default btn-owner-name" title="作者: <?= $survey->owner->screen_name ?>">
								<i class="glyphicon glyphicon-user"></i>@<?= $survey->owner->screen_name ?>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8 survey-cont tagbox">
				<p class="btn-group-tags">
					<i class="glyphicon glyphicon-tags"></i>
					<?php
					foreach ($survey->tags as $tag)
					{
						?>
						<a href="<?= base_url("tag/" . $tag) ?>" class="btn btn-primary btn-tag btn-xs"><?= $tag ?></a>
					<?php } ?>
				</p>
			</div>
		</div>

		<!--div class="row">
			<div class="col-sm-2">
				<i class="glyphicon glyphicon-ok"></i>
		<?= $survey->get_total() ?>票
			</div>
		</div-->
	</div>

	<div class="row" id="survey-pager-div">

		<?php if ($survey->state === SURVEY_STATE_PROGRESS)
		{ ?>
			<div class="col-sm-2">
				あと<?= $survey->get_time_remain_str() ?>
			</div>
			<div class="col-sm-4">
				<div class="progress">
					<div class="progress-bar" style="width: <?= $survey->get_time_progress_par() ?>%;"></div>
				</div>
			</div>
<?php } ?>
		<div class="col-sm-4 col-sm-offset-8">
			<div class="btn-group btn-group-justified">
				<a href="<?= base_url($survey->id)?>" class="btn btn-default<?= (($type === SURVEY_PAGETYPE_VOTE) ? ' disable':'')?>"><i class="glyphicon glyphicon-import"></i>投票</a>
				<a href="<?= base_url('view/'.$survey->id)?>" class="btn btn-default<?= (($type === SURVEY_PAGETYPE_VIEW) ? ' disable':'')?>"><i class="glyphicon glyphicon-stats"></i>結果</a>
			</div>
		</div>
	</div>
</div>