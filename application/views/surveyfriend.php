<?php
/* @var $survey Surveyobj */
/* @var $friends Userobj[] */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="itemresultbox-soted-div">
			<h2>Twitterフレンドの投票先</h2>
			<?php
			if (!empty($friends))
			{
				?>
			<ul>
				<?php
				foreach ($survey->items as $item)
				{
					$i = $item->index;
					// btn state define page loaded start view
					?>
					<li>
						<div class="panel panel-itemselect">
							<div class="panel-headding">
								<span><?= $item->value ?></span>
							</div>
							<div class="panel-body">
								<?php
								foreach ($friends as $user)
								{
									if ($i == $user->select)
									{
										?>
								<div>
									<span>@<?= $user->screen_name ?></span>
									<img src="<?= $user->img_url ?>" alt="<?= $user->screen_name ?>プロフィール画像" />
								</div>

								<?php
									}
								}
								?>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
			<?php
			} else {
			?>
			<p>あなたのTwtterフレンド(フォローユーザー)はまだこの投票に投票していません</p>
			<?php }
			?>
		</div>
	</div>
</div>

