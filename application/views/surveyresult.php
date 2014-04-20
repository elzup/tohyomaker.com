<?php
/* @var $survey Surveyobj */
?>
<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="itemresultbox-soted-div">
			<?php
			if ($survey->state == SURVEY_STATE_PROGRESS)
			{
				?>
				<h2>投票結果</h2>
				<?php
			} else
			{
				?>
				<h2>投票結果</h2>
			<?php } ?>
			<div>
				<?php
				if ($survey->state == SURVEY_STATE_END || $survey->selected != NO_VOTED)
				{
					// TODO: item sort after view 
					$sum_cn = 0;
					foreach ($survey->get_sorted() as $i => $item)
					{
						$cn = calc_item_col($i, count($survey->items));
						$text_tooltip = ($survey->is_selected_today) ? 'あなたが投票した項目' : '前回投票した項目';
						$voted_icon = (
								($item->index === $survey->selected) ? '<span class="voted" ' . attr_tooltip($text_tooltip) . '>' . tag_icon(ICON_VOTED, TRUE) . '</span>' : '');
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
				} else
				{
					?>
					<div class="well">
						<p>まだ投票していません</p>
						<span class="help-block">投票するかこの投票の集計記録がされると見ることが出来ます</span>
					</div>

					<?php
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
						<div class="col-xs-5">
							<i class="<?= ICON_OK ?>"></i>
							<?= $survey->total_num ?> 票
						</div>
						<div class="col-xs-2">
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
		<?php
		if (!$survey->is_selected_today)
		{
			?>
			<div class="col-sm-offset-2 col-sm-8 abutton">
				<a <?= attr_href(PATH_VOTE, $survey->id) ?> class="btn btn-success btn-lg btn-block">
					<i class="<?= ICON_VOTE ?>"></i>
					投票ページヘ
				</a>
			</div>
		<?php } ?>
	</div>
</div>
