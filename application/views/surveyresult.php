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
			<div class="row">
				<?php
				// TODO: item sort after view 
				$sum_cn = 0;
				foreach ($survey->get_sorted() as $i => $item)
				{
					$cn = calc_item_col($i, count($survey->items));
					$voted_icon = (($item->index == $select) ? '<span class="voted" data-toggle="tooltip" data-placement="top" title="あなたが投票した項目"><i class="glyphicon glyphicon-flag"></i></span>' : '');
					if ($sum_cn % 12 == 0)
					{
						?>
						<div class="row">
						<?php }
						?>
						<div class="col-sm-<?= $cn ?>">
							<div class="panel panel-success rank-<?= $item->rank ?>">
								<div class="panel-heading">
									<span class="rank"><?= $item->rank ?></span>
									<?= $voted_icon ?>
								</div>
								<div class="panel-body">
									<h4>
										<?= $item->value ?>
									</h4>
									<h4 class="num">
										<?= $item->num ?>
									</h4>
								</div>
							</div>
						</div>
						<?php
						$sum_cn += $cn;
						if ($sum_cn % 12 == 0)
						{
							?>
						</div>
						<?php
					}
				}
				?>
			</div>
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
