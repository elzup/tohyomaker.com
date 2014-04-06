<?php
/* @var $surveys_voted Surveyobj[] */
/* @var $surveys_maked Surveyobj[] */
/* @var $user Userobj */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="mypage-div">

			<ul class="nav nav-tabs">
				<li class="active"><a href="#vote-history-tab" data-toggle="tab">投票履歴</a></li>
				<li><a href="#created-survey-tab" data-toggle="tab">作成した投票</a></li>
			</ul>

			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="vote-history-tab">
					<h2>最近の投票履歴</h2>
					<span class="help-block">一定時間たつと個人の投票データは消去されます</span>
					<?php
					if (!empty($surveys_voted))
					{
						foreach ($surveys_voted as $survey)
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
				<div class="tab-pane fade" id="created-survey-tab">
					<h2>作成した投票</h2>
					<?php
					if (!empty($surveys_maked))
					{
						foreach ($surveys_maked as $survey)
						{
							surveypane($survey);
						}
					} else
					{
						?>
						<p>作成した投票はありません</p>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>