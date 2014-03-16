<?php
if (!function_exists('surveypane'))
{

	function surveypane(SurveyObj $survey, $prefix = '・')
	{
		?>
		<div class="panel panel-default panel-sp">
			<!--div class="panel-heading"></div-->
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

	}

}