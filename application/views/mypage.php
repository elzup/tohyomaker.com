<?php
/* @var $surveys SurveyObj[] */
/* @var $survey SurveyObj */
/* @var $user UserObj */
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
					<?php
					foreach ($surveys as $survey)
					{
						surveypane($survey);
					}
					?>
				</div>
				<div class="tab-pane fade" id="created-survey-tab">
					TODO: 投票作成履歴を表示
				</div>
			</div>
		</div>
	</div>
</div>