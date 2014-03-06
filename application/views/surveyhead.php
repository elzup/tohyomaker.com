<?php
/* @var $survey SurveyObj */
/* @var $owner UserObj */
/* @var $type int */

?>

<div class="container">
	<div class="well">
		<div class="row">
			<div id="title-survey-div" class="col-sm-10">
				<h1 id="title-survey"><?= $survey->title ?></h1>
			</div>
			<div class ="col-sm-2" id="pagetype">投票ページ</div>
		</div>
		<div class="row">
			<div class="col-sm-8" id="tagbox-div">
				<p class="btn-group-tags">
					<i class="glyphicon glyphicon-tags"></i> : 
					<?php foreach ($survey->tags as $tag)
					{ ?>
						<a href="<?= base_url("tag/" . $tag) ?>" class="btn btn-primary btn-tag btn-xs"><?= $tag ?></a>
					<?php } ?>
				</p>
			</div>
			<div class="col-sm-2" id="timestamp"><?=$survey->get_time()?></div>
			<div class="col-sm-2" id="owner-name">
				<p>
					<a href="<?=  base_url("user/{$survey->owner->id}")?>" class="btn btn-default btn-owner-name">作者: @<?=$survey->owner->screen_name?></a>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12" id="survey-description">
				<?= $survey->description?>
			</div>
		</div>
	</div>
	<div class="row" id="pager">
		<div class="col-sm-4 col-sm-offset-8">
			<div class="btn-group btn-group-justified">
				<a href="./vote.html" class="btn btn-default disabled"><i class="glyphicon glyphicon-import"></i>投票</a>
				<a href="./view.html" class="btn btn-default"><i class="glyphicon glyphicon-stats"></i>結果</a>
			</div>
		</div>
	</div>
</div>