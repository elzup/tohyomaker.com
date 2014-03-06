<?php

if (!function_exists('surveypane'))
{
	function surveypane(SurveyObj $survey, $prefix = '・')
	{
		?>
			<div class="panel panel-default panel-sp">
				<!--div class="panel-heading"></div-->
				<div class="panel-heading">
					<h3><p><?=$prefix?><a href="<?= base_url($survey->id)?>"><?=$survey->title?></a></p></h3>
				</div>
				<div class="panel-body">
					<p><?=$survey->description?></p>
					<div class="btn-group btn-group-itmes">
						<?php foreach ($survey->items as $i => $item) {?>
						<a href="<?= base_url($survey->id .'/'. $i )?>" class="btn btn-primary btn-item btn-sm"><?=$item?></a>
						<?php } ?>
					</div>
				</div>
				<div class="panel-footer">
					<p class="btn-group-tags">
						<i class="glyphicon glyphicon-tags"></i> : 
						<?php foreach ($survey->tags as $tag) {?>
						<a href="<?= base_url("tag/".$tag)?>" class="btn btn-primary btn-tag btn-xs"><?=$tag?></a>
						<?php } ?>
					</p>
				</div>
			</div>
<?php
	}
}
