<?php
if (!function_exists('surveysblock_type'))
{

	/**
	 * 
	 * @param SurveyObj[] $surveys
	 * @param int $type
	 */
	function surveysblock_type(array $surveys, $type)
	{
		$block_title = '新着';
		$block_help = '開始されたばかりの投票';
		$class_str = 'new';
		switch ($type)
		{
			case SURVEY_BLOCKTYPE_HOT:
				$block_title = '人気';
				$block_help = '今勢いのある投票';
				$class_str = 'hot';
				break;
			default:
// type-new defined so skip
				break;
		}
		surveysblock($surveys, $block_title, $block_help, $class_str);
	}

}


if (!function_exists('surveysblock'))
{

	/**
	 * 
	 * @param SurveyObj[] $surveys
	 * @param string $title
	 * @param string $help
	 * @param string $class_str
	 */
	function surveysblock($surveys, $title, $help, $class_str)
	{
		?>

		<div class="panel panel-default panel-surveys-<?= $class_str ?>">
			<div class="panel-heading">
				<p><?= $title ?> - <?= $help ?></p>
			</div>
			<div class="panel-body">
				<ul class="surveyslist">
					<?php
					foreach ($surveys as $survey)
					{
						// TODO: create view
						?>
					
						<li><?= $survey->title ?></li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}

}
	