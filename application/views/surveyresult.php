<?php
/* @var $survey Surveyobj */
?>
<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="itemresultbox-soted-div">
			<?php if ($survey->state == SURVEY_STATE_PROGRESS)
			{
			?>
			<h2>現在の投票結果</h2>
			<?php } else { ?>
				<h2>最終投票結果</h2>
				<?php } ?>
			<div class="row">
				<?php
				// TODO: item sort after view 
				$sum_cn = 0;
				foreach ($survey->get_sorted() as $i => $item)
				{
					$cn = calc_item_col($i, count($survey->items));
					$voted_icon = (
							($item->index === $survey->selected) ? '<span class="voted" ' . attr_tooltip('あなたが投票した項目') . '>' . tag_icon(ICON_VOTED, TRUE) . '</span>' : '');
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
		<div class="col-sm-offset-2 col-sm-8" id="itemresultbox-soted-div">
			<div class="panel panel-success panel-log">
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-5">
							<i class="<?= ICON_TIME ?>"></i>
							経過時間 <?= $survey->get_time_progress_str() ?>
						</div>
						<div class="col-sm-5">
							<i class="<?= ICON_OK ?>"></i>
							<?= $survey->total_num ?> 票
						</div>
						<div class="col-sm-2">
							<?php
							$share_uri = base_url(PATH_VIEW . '/' . $survey->id);
							$share_text = totext_share_result($survey);
							echo sharebtn_twitter($share_text, $share_uri);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
