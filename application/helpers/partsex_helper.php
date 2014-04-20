<?php
if (!function_exists('surveypane'))
{

	function surveypane(Surveyobj $survey, $is_log = FALSE)
	{
		?>
		<div class="panel panel-success panel-survey">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-10 title">
						<h4>
							<p>
								<a <?= attr_href(PATH_VOTE, $survey->id) ?>><?= $survey->title ?></a>
							</p>
						</h4>
					</div>
					<div class="col-xs-2 total-num">
						<span class="total-num"><?= $survey->total_num ?></span>
					</div>
				</div>
				<?php
				if ($is_log && ($selected = $survey->selected) !== NO_VOTED)
				{
					$item = $survey->get_selected_item();
					// not voted yet
					?>
					<div>
						<a <?= attr_href(PATH_VOTE, $survey->id) ?> class="btn btn-success btn-item btn-sm"><?= $item->value ?></a>
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
					</div>
					<div class="btn-group-itmes hidden-xs">
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
									<a <?= attr_href(PATH_VOTE, array($survey->id, $i)) ?> class="btn btn-block btn-item btn-sm<?= $class ?>"><?= $item->value ?></a>
								</div>
								<?php
								$sum_cn += $cn;
							}
							?>
						</div>
					</div>
					<div class="btn-group-itmes visible-xs">
						<div class="well">
							<p><?= $survey->get_text_items() ?></p>
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
						<a <?= attr_href(PATH_TAG, $tag) ?> class=""><?= $tag ?></a>
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

if (!function_exists('div_twitter_user'))
{

	function div_twitter_user(Userobj $user)
	{
		?>
		<div class="twitter-user-div">
			<a href="<?= "https://twitter.com/{$user->screen_name}" ?>">
				<img src="<?= $user->img_url ?>" <?= attr_tooltip('@' . $user->screen_name) ?> />
			</a>
		</div>

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

if (!function_exists('surveysblock_type'))
{

	/**
	 * 
	 * @param Surveyobj[] $surveys
	 * @param int $type
	 */
	function surveysblock_type($surveys, $type)
	{
		$block_title = '新着';
		$block_help = '開始されたばかりの投票';
		$class_str = 'new';
		$class_str_icon = ICON_NEW;
		$path = PATH_NEW;
		switch ($type)
		{
			case SURVEY_BLOCKTYPE_HOT:
				$block_title = '人気';
				$block_help = '今勢いのある投票';
				$class_str = 'hot';
				$class_str_icon = ICON_HOT;
				$path = PATH_HOT;
				break;
			default:
// type-new defined so skip
				break;
		}
		surveysblock($surveys, $block_title, $block_help, $class_str, $class_str_icon, $path);
	}

}


if (!function_exists('surveysblock'))
{

	/**
	 * 
	 * @param Surveyobj[] $surveys
	 * @param string $title
	 * @param string $help
	 * @param string $class_str
	 */
	function surveysblock($surveys, $title, $help, $class_str, $class_str_icon, $path)
	{
		?>

		<div class="panel panel-success panel-surveys panel-surveys-<?= $class_str ?>">
			<div class="panel-heading">
				<p>
					<?= tag_icon($class_str_icon) ?>
					<a <?= attr_href($path) ?>><span class="title"><?= $title ?></span> - <span class="help"><?= $help ?></span></a>
				</p>
			</div>
			<div class="panel-body">
				<ul>
					<?php
					if (!empty($surveys))
					{
						foreach ($surveys as $survey)
						{
							$voted_tag = '';
							if ($survey->is_voted())
							{
								$voted_tag = '<span class="voted"' . attr_tooltip('投票済み') . '>' . tag_icon(ICON_VOTED, TRUE) . '</span>';
							}
							?>
							<li class="row">
								<span class="title col-xs-8"><a <?= attr_href(PATH_VOTE, $survey->id) ?>><?= $survey->title ?></a></span>
								<span class="total-num col-sm-2 col-xs-4"><?= $voted_tag ?><?= $survey->total_num ?></span>
								<span class="remain col-xs-2 hidden-xs"><?= ($survey->state == SURVEY_STATE_END) ? '' : tag_icon(ICON_TIME, TRUE) . $survey->get_time_remain_str() ?></span>
							</li>
							<?php
						}
						?>
						<li>
							<a <?= attr_href($path) ?> style="float:right;" class="btn btn-success">もっと見る</a>
						</li>
						<?php
					} else
					{
						?>
						<p><?= $title ?>の投票はありません</p>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}

}
	

if (!function_exists('attr_tooltip_selectform'))
{

	function attr_tooltip_selectform($i, Surveyobj $survey)
	{
		$btn_tooltip_text = '';
		if ($survey->selected === $i)
		{
			$btn_tooltip_text = '前回の投票先';
		}
		if ($survey->is_voted())
		{
			$btn_tooltip_text = '本日は投票済み';
		}
		return empty($btn_tooltip_text) ? '' : attr_tooltip($btn_tooltip_text);
	}
}
if (!function_exists('attr_class_selectform'))
{
	function attr_class_selectform($i, Surveyobj $survey, $select)
	{
		$add_class = '';
		if ((isset($select) && $i == $select) || $survey->selected == $i)
		{
			$add_class .= ' active';
			if ($survey->is_voted()) {
				$add_class .= ' disabled btn-static';
			}
		} else if ($survey->is_voted())
		{
			$add_class .= ' no-display';
		}
		return $add_class;
	}
}
if (!function_exists('tag_icon_selectform'))
{
	function tag_icon_selectform($i, $survey_select, $select)
	{
		return tag_icon(((isset($select) && $i === $select) || $survey_select === $i) ? ICON_OK : ' ');
	}

// TODO: cut severally function_exits
}