<?php
/* @var $survey Surveyobj */
/* @var $friends Userobj[] */
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="itemfriendbox-div">
			<h2>Twitterフレンドの投票先</h2>
			<?php
			if (!empty($friends))
			{
				/* order friends select */
				$item_voted_user;
				foreach ($friends as $user)
				{
					$users_in_item[$user->select][] = $user;
				}
				?>
				<ul>
					<?php
					foreach ($survey->items as $item)
					{
						$i = $item->index;
						// btn state define page loaded start view
						?>
						<li>
							<div class="panel panel-success panel-friendselect">
								<div class="panel-body">
									<span class="item-name"><?= $item->value ?></span>
									<?php
									if (isset($users_in_item[$i]))
									{
										echo '<div class="friends-div">';
										foreach ($users_in_item[$i] as $user)
										{
											echo div_twitter_user($user);
										}
										echo '</div>';
									} else
									{
										?>
										<p>この項目に投票したフレンドはいません</p>
										<?php
									}
									?>
								</div>
							</div>
						</li>
				<?php } ?>
				</ul>
				<?php
			} else
			{
				?>
				<p>あなたのTwtterフレンド(フォローユーザー)はまだこの投票に投票していません</p>
<?php }
?>
		</div>
	</div>
</div>

