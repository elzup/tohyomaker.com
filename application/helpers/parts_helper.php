<?php
if (!function_exists('surveypane'))
{

	function surveypane(Surveyobj $survey, $is_log = FALSE)
	{
		?>
		<div class="panel panel-success panel-survey">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-10 title">
						<p>
						<h4><a <?= attr_href(HREF_TYPE_VOTE, $survey->id) ?>><?= $survey->title ?></a>
							<?php
							/*
							if (($result_num = $survey->get_result_num()) !== 0)
							{
								?>
								<a <?= attr_href(HREF_TYPE_VIEW, $survey->id) ?>><span class="badge"><?= $result_num ?></span></a>
								<?php
							}
							 */
							?>
						</h4></p>
					</div>
					<!--div class="col-sm-1 state"></div-->
					<div class="col-sm-2 total-num">
						<span class="total-num"><?= $survey->total_num ?></span>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<?php
				if ($is_log && ($selected = $survey->selected) !== NO_VOTED)
				{
//					$share_uri = base_url($survey->id);
//					$share_text = totext_share($survey->items[$selected]->value, $survey->title, $share_uri);

					$item = $survey->get_selected_item();
					// not voted yet
					?>
					<div>
						<a <?= attr_href(HREF_TYPE_VOTE, $survey->id) ?> class="btn btn-success btn-item btn-xs"><?= $item->value ?></a>
						に投票しました。
					</div>
					<?php
				} else
				//already voted
				{
					?>
					<div class="row">
						<div class="col-sm-8 col-sm-8-s">
							<p><?= tag_icon(ICON_DESCRIPTION, !!$survey->description) . (($survey->description) ? : NO_PARAM_STR) ?></p>
						</div>
						<!--div class="col-sm-12">
							<p><?= $survey->get_text_items() ?></p>
						</div-->
						<!--div class="col-sm-10">time bar</div>
						<div class="col-sm-2 atleast">残り </div-->
					</div>
					<div class="btn-group-itmes">
						<div class="row">
							<?php
							$cn = calc_item_col_equality(count($survey->items));
							$sum_cn = 0;
							foreach ($survey->items as $i => $item)
							{
								$class = '';
								if ($survey->is_selected_today)
								{
									$class .= ' disabled';
								}
								$class .= ($survey->selected === $item->index ? ' btn-warning' : ' btn-success ');
								?>
								<div class="col-sm-<?= $cn ?>">
									<a <?= attr_href(HREF_TYPE_VOTE, array($survey->id, $i)) ?> class="btn btn-block btn-item btn-sm<?= $class ?>"><?= $item->value ?></a>
								</div>
								<?php
								$sum_cn += $cn;
							}
							?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="panel-footer">
				<p class="btn-group-tags">
					<?= tag_icon(ICON_TAG, TRUE) ?>
					<?php
					foreach ($survey->tags as $tag)
					{
						?>
						<a <?= attr_href(HREF_TYPE_TAG, $tag) ?> class="btn btn-success btn-tag btn-xs"><?= $tag ?></a>
					<?php } ?>
				</p>

				<!--div class="row">
					<div class="col-sm-3">
						<?= tag_icon(ICON_TIME, TRUE) ?>
						<?= $survey->get_time_remain_str() ?>
					</div>
					<?php
					$stylelib = explode(',', 'success,end,end');
					$pbstyle = $stylelib[$survey->state];
					?>
					<div class="col-sm-9">
						<div class="progress">
							<div class="progress-bar progress-bar-<?= $pbstyle ?>" style="width: <?= $survey->get_time_progress_par() ?>%;"></div>
						</div>
					</div>
				</div-->
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
			 data-lang="ja">ツイートする</a>
			 <?php
		 }

	 }




	 if (!function_exists('logpane'))
	 {

		 function logpane(Resultobj $result, Surveyobj $survey = NULL, $is_title = FALSE)
		 {
			 ?>
		<div class="panel panel-success panel-log">
			<div class="panel-body">

				<table class="table table-striped table-hover">
					<tbody>
						<?php
						foreach ($result->items as $item)
						{
							$crown = '';
							if (($rank = $item->rank) < 4)
							{
								$collib = explode(',', 'gold,silver,bronds');
								$col = $collib[$rank - 1];
								$crown = '<i class="<?=?> col-' . $col . '"></i>';
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

			<div class="panel-footer">
				<div class="row <?= $result->type == RESULT_TYPE_TIME ? 'result-type-time' : 'result-type-total' ?>">
					<div class="col-sm-5">
						<i class="<?= ICON_TIME ?>"></i>
						経過時間 <?= $result->get_elapsed_time_str() ?>
					</div>
					<div class="col-sm-5">
						<i class="<?= ICON_OK ?>"></i>
						<?= $result->get_total() ?> 票
					</div>
					<div class="col-sm-2">
						<?php
						$share_uri = base_url(PATH_VIEW . '/' . $survey->id);
						$share_text = totext_share_result($survey, $result);
						sharebtn_twitter($share_text, $share_uri)
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}

if (!function_exists('searchbox_tag'))
{

	function searchbox_tag()
	{
		$name = 'タグ検索';
		// TODO: fix omis to 'tag'
		$action = base_url('search/tag');
		$class_str_icon = ICON_SEARCHTAG;
		searchbox($name, $action, $class_str_icon);
	}

}

// TODO: add other type search, exteding func searchbox


if (!function_exists('searchbox'))
{

	function searchbox($name, $action, $class_str_icon)
	{
		?>
		<div class="align-center">
			<form class="form-horizontal" action="<?= $action ?>" method="GET">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label"><?= tag_icon($class_str_icon) . $name ?></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="s" placeholder="<?= $name ?>" maxlength="20">
					</div>
					<div class="col-sm-2">
						<button type="submit" id="submit-main" class="btn btn-block btn-success">検索</button>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

}

if (!function_exists('tag_icon'))
{

	function tag_icon($class, $is_color = FALSE, $color = 'orange')
	{
		if ($is_color)
		{
			$class .= ' icon-' . $color;
		}
		return '<i class="' . $class . '"></i>';
	}

}


if (!function_exists('attr_href'))
{

	function attr_href($type = PATH_TOP, $values = NULL, $is_wrap_base = TRUE)
	{
		$link = $type;
		// TODO: support array $option_value args
		if (!empty($values))
		{
			if (!is_array($values))
			{
				$values = explode('/', $values);
			}
			$link .= '/' . implode('/', urlencode_array($values));
		}

		if ($is_wrap_base)
		{
			$link = base_url($link);
		}
		return 'href="' . $link . '"';
	}

}

if (!function_exists('attr_tooltip'))
{

	function attr_tooltip($str)
	{
		return ' data-toggle="tooltip" data-placement="top" title="' . $str . '"';
	}

}

if (!function_exists('votelogpane'))
{

	function votelogpane(Surveyobj $survey, $select)
	{

		// TODO: make function view of voted history pane
	}

}

if (!function_exists('calc_item_col_equality'))
{

	function calc_item_col_equality($index)
	{
		$lib = array(FALSE, FALSE, 6, 4, 3, 4, 4, 3, 3, 4, 3);

		return $lib[$index] ? : FALSE;
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

