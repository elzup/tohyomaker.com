<?php
/* @var $survey SurveyObj */
/* @var $owner UserObj */
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
							<i class="glyphicon glyphicon-comment icon-orange"></i><?= $survey->description ?>
						</div>
					</div>
				<?php } ?>
				<?php
				if (isset($survey->target))
				{
					?>
					<div class="row">
						<div class="col-sm-12 survey-cont target">
							<i class="glyphicon glyphicon-flag icon-orange"></i><?= $survey->target ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-6 survey-cont timestamp"><i class="glyphicon glyphicon-time icon-orange"></i><?= $survey->get_time() ?></div>
					<div class="col-sm-6 owner-name">
						<p>
							<a href="<?= base_url("user/{$survey->owner->id}") ?>" class="btn btn-success btn-owner-name" data-toggle="tooltip" data-placement="top" title="作者: <?= $survey->owner->screen_name ?>">
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
					<i class="glyphicon glyphicon-tags icon-orange"></i>
					<?php
					foreach ($survey->tags as $tag)
					{
						?>
						<a href="<?= base_url("tag/" . $tag) ?>" class="btn btn-success btn-tag btn-xs"><?= $tag ?></a>
					<?php } ?>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<i class="glyphicon glyphicon-time icon-orange"></i>
				<?= $survey->get_time_remain_str() ?>
			</div>
			<?php
			$stylelib = explode(',', 'success,end,end');
			$pbstyle = $stylelib[$survey->state];
			?>
			<div class="col-sm-10">
				<div class="progress">
					<div class="progress-bar progress-bar-<?= $pbstyle ?>" style="width: <?= $survey->get_time_progress_par() ?>%;"></div>
				</div>
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

		<div class="col-sm-4 col-sm-offset-8">
			<div class="btn-group btn-group-justified">
				<a href="<?= base_url($survey->id) ?>" class="btn btn-success<?= (($type === SURVEY_PAGETYPE_VOTE) ? ' disabled' : '') ?>">
					<i class="glyphicon glyphicon-import"></i>
					投票
				</a>
				<a href="<?= base_url('view/' . $survey->id) ?>" class="btn btn-success<?= (($type === SURVEY_PAGETYPE_VIEW) ? ' disabled' : '') ?>">
					<i class="glyphicon glyphicon-stats"></i>
					結果
					<?php
					if (($c = count($survey->results)))
					{
						?>
						<span class="badge"><?= $c ?></span>
					<?php } ?>
				</a>
			</div>
		</div>
	</div>
</div>