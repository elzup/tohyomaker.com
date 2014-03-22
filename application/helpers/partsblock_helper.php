<?php
if (!function_exists('surveysblock_type'))
{

	/**
	 * 
	 * @param Surveyobj[] $surveys
	 * @param int $type
	 */
	function surveysblock_type(array $surveys, $type)
	{
		$block_title = '新着';
		$block_help = '開始されたばかりの投票';
		$class_str = 'new';
		$class_str_icon = ICON_NEW;
		switch ($type)
		{
			case SURVEY_BLOCKTYPE_HOT:
				$block_title = '人気';
				$block_help = '今勢いのある投票';
				$class_str = 'hot';
				$class_str_icon = ICON_HOT;
				break;
			default:
// type-new defined so skip
				break;
		}
		surveysblock($surveys, $block_title, $block_help, $class_str, $class_str_icon);
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
	function surveysblock($surveys, $title, $help, $class_str, $class_str_icon)
	{
		?>

		<div class="panel panel-success panel-surveys panel-surveys-<?= $class_str ?>">
			<div class="panel-heading">
				<p>
					<?= tag_icon($class_str_icon) ?>
					<span class="title"><?= $title ?></span> - <span class="help"><?= $help ?></span>
				</p>
			</div>
			<div class="panel-body">
				<ul>
					<?php
					foreach ($surveys as $survey)
					{
						$voted_tag = '';
						if ($survey->is_voted())
						{
							$voted_tag = '<span class="voted"' . attr_tooltip('投票済み') . '>' . tag_icon(ICON_VOTED, TRUE) . '</span>';
						}
						?>
						<li class="row">
							<span class="title col-sm-8"><a <?= attr_href(HREF_TYPE_VOTE, $survey->id) ?>><?= $survey->title ?></a></span>
							<span class="total-num col-sm-2"><?= $voted_tag ?><?= $survey->total_num ?></span>
							<span class="remain col-sm-2"><?= tag_icon(ICON_TIME, TRUE) . $survey->get_time_remain_str() ?></span>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}

}
	