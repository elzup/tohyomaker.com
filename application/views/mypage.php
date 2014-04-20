<?php
/* @var $surveys Surveyobj[] */
/* @var $user Userobj */
/* @var $type int */
$is_type_voted  = $type == PAGETYPE_VOTED;
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="mypage-div">

			<ul class="nav nav-tabs">
				<li class="<?= ($type == PAGETYPE_VOTED ? 'active' : '') ?>">
					<a <?= attr_href($type == PAGETYPE_VOTED ? '#' : (PATH_MYPAGE)) ?>>投票履歴</a>
				</li>
				<li class="<?= ($type == PAGETYPE_MAKED ? 'active' : '') ?>">
					<a <?= attr_href($type == PAGETYPE_MAKED ? '#' : (PATH_MYPAGEMAKED)) ?>>作成した投票</a>
				</li>
			</ul>

			<?php
			if ($type == PAGETYPE_VOTED)
			{
				?>
				<div class="" id="vote-history-tab">
					<h2>最近の投票履歴</h2>
					<span class="help-block">一定時間たつと個人の投票データは消去されます</span>
					<?php
					if (!empty($surveys))
					{
						foreach ($surveys as $survey)
						{
							surveypane($survey, TRUE);
						}
					} else
					{
						?>
						<p>最近の投票履歴はありません</p>
						<?php
					}
					?>
				</div>
				<?php
			} else
			{
				?>
				<div class="" id="created-survey-tab">
					<h2>作成した投票</h2>
					<?php
					if (!empty($surveys))
					{
						foreach ($surveys as $survey)
						{
							surveypane($survey, FALSE, TRUE);
						}
					} else
					{
						?>
						<p>作成した投票はありません</p>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>