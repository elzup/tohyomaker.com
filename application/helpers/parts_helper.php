<?php
if (!function_exists('surveypane'))
{

	function surveypane(SurveyObj $survey, $prefix = '・')
	{
		?>
		<div class="panel panel-default panel-sp">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-1"><?= $prefix ?></div>
					<div class="col-sm-9">

						<h3><p><a href="<?= base_url($survey->id) ?>"><?= $survey->title ?></a></p></h3>
					</div>
					<div class="col-sm-2">
						<span class="total-num"><?= $survey->get_total() ?></span>票
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<p><?= $survey->description ?></p>
					</div>
					<div class="col-sm-6">
						<p><?= $survey->target ?></p>
					</div>
					<div class="col-sm-12">
						<p><?= $survey->get_text_items() ?></p>
					</div>
					<div class="col-sm-10">time bar</div>
					<div class="col-sm-2">残り N 時間</div>
				</div>
				<!--div class="btn-group btn-group-itmes">
				<?php
				foreach ($survey->items as $i => $item)
				{
					?>
														<a href="<?= base_url($survey->id . '/' . $i) ?>" class="btn btn-primary btn-item btn-sm"><?= $item ?></a>
				<?php } ?>
				</div-->
			</div>
			<div class="panel-footer">
				<p class="btn-group-tags">
					<i class="glyphicon glyphicon-tags"></i> : 
					<?php
					foreach ($survey->tags as $tag)
					{
						?>
						<a href="<?= base_url("tag/" . $tag) ?>" class="btn btn-primary btn-tag btn-xs"><?= $tag ?></a>
					<?php } ?>
				</p>
			</div>
		</div>
		<?php
	}

}

if (!function_exists('sharebtn_twitter'))
{

	function sharebtn_twitter($text, $uri)
	{
		?>
		<a href="http://twitter.com/share" class="twitter-share-button"
			 data-url="<?= $uri ?>"
			 data-text="<?= $text ?>"
			 data-count="horizontal"
			 data-lang="ja">Tweet</a>
			 <?php
		 }

	 }

	 if (!function_exists('alert_box'))
	 {

		 function alert_box($type)
		 {
			 $lib = array(
					 "投票が完了しました。",
					 "ログアウトしました。",
			 );
			 if (empty($lib[$type]))
			 {
				 return;
			 }
			 $text = $lib[$type];
			 $alert_type = 'alert-success';
			 ?>
		<div class="alert alert-dismissable <?= $alert_type ?>">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p><?= $text ?></p>
		</div>
		<?php
	}

}

if (!function_exists('logpane'))
{

	function logpane(ResultObj $result)
	{
		?>
		<div class="panel panel-success panel-log">
			<div class="panel-heading">
				<div class="row <?= $result->is_booked() ? 'reuslt-type-time' : 'reuslt-type-total' ?>">
					<div class="col-sm-5">
						<i class="glyphicon glyphicon-time"></i>
						経過時間 <?= $result->get_elapsed_time_str() ?>
					</div>
					<div class="col-sm-5">
						<i class="glyphicon glyphicon-ok"></i>
						<?= $result->get_total() ?> 票
					</div>
				</div>
			</div>
			<div class="panel-body">

				<table class="table table-striped table-hover">
					<tbody>
						<?php
						foreach ($result->items as $i => $item)
						{
							$crown = '';
							if (($rank = $item->rank) < 4)
							{
								$collib = explode(',', 'gold,silver,bronds');
								$col = $collib[$rank - 1];
								$crown = '<i class="glyphicon glyphicon-star col-' . $col . '"></i>';
							}
							?>
							<tr>
								<td class="rank rank-<?= $rank ?>"><?= $crown ?><?= $rank ?></td>
								<td class="itemanme"><?= $item->value ?></td>
								<td class="num"><?= $item->num ?></td>
							</tr>
						<?php } ?>

					</tbody>
				</table> 
			</div>
		</div>
		<?php
	}

}
if (!function_exists('calc_item_col'))
{

	function calc_item_col($index, $num)
	{
		$lib = array(
				FALSE, FALSE,
				array(6, 6),
				array(4, 4, 4),
				array(6, 6, /**/ 6, 6),
				array(6, 6, /**/ 4, 4, 4),
				array(4, 4, 4, /**/ 4, 4, 4),
				array(4, 4, 4, /**/ 3, 3, 3, 3),
				array(3, 3, 3, 3, /**/ 3, 3, 3, 3),
				array(4, 4, 4, /**/ 4, 4, 4, /**/ 4, 4, 4),
				array(4, 4, 4, /**/ 4, 4, 4, /**/ 3, 3, 3, 3),
		);

		return $lib[$num][$index] ? : FALSE;
	}

}

