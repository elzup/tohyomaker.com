<?php

if (!function_exists('surveypane'))
{
	function surveypane(SurveyObj $survey, $prefix = '・')
	{
		?>
			<div class="panel panel-default panel-sp">
				<!--div class="panel-heading"></div-->
				<div class="panel-body">
					<h4><p><?=$prefix?><a href="#"><?=$survey->title?></a></p></h4>
					<p><?=$survey->discription?></p>
					<div class="btn-group btn-group-itmes">
						<?php foreach ($survey->items as $item) {?>
						<button type="button" class="btn btn-primary btn-item btn-sm"><?=$item?></button>
						<?php } ?>
					</div>
				</div>
				<div class="panel-footer">
					<p class="btn-group-tags">
						<i class="glyphicon glyphicon-tags"></i> : 
						<?php foreach ($survey->tags as $tag) {?>
						<button type="button" class="btn btn-primary btn-tag btn-xs"><?=$tag?></button>
						<?php } ?>
					</p>
				</div>
			</div>
<?php
	}
}
