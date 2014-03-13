<?php
/** @var $survey SurveyObj */
if (!isset($select))
{
	$select = -1;
}
?>
<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="itemresultbox-soted-div">
			<ul>
				<?php
				// TODO: item sort after view 
				foreach ($survey->get_sorted() as $i => $item)
				{
					?>
					<li>
						<div class="panel panel-default rank-<?= $item->rank ?>">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-8">
										<h4>
											<?= $item->value ?>
											<?php echo (($item->index == $select) ? '<i class="glyphicon glyphicon-ok"></i>' : '') ?>
										</h4>
									</div>
									<div class="col-sm-4">
										<h4 class="num">
											<?= $item->num ?>
										</h4>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
		<div class="col-sm-offset-2 col-sm-8" id="itemresultbox-div" style="display: none;">
			<ul>
				<?php
				// TODO: item sort after view 
				foreach ($survey->items as $i => $item)
				{
					?>
					<li>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-9">
										<h4>
											<?= $item->value ?>
										</h4>
									</div>
									<div class="col-sm-3">
										<h4 class="num">
											<?= $item->num ?>票
										</h4>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
