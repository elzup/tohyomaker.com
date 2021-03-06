<?php
/* @var $survey Surveyobj */
/* @var $user Userobj */
/* @var $select int */

//debug 
//$survey->is_img = TRUE;
// TODO: move func file
?>

<div class="container">
	<div class="row" id="voted-div">
		<?php
		if ($survey->is_voted())
		{
			$selected_item = $survey->get_selected_item();
			$share_uri = fix_url(base_url(PATH_VOTE . $survey->id));
			$share_text = totext_share_voted($selected_item->value, $survey->title);
			?>

			<div class="col-sm-offset-2 col-sm-8 well" class="selected-view-div">
				<h3><?= totext_voted($selected_item->value) ?></h3>
				<span class="help-block">*一日に一票投票することが出来ます</span>
			</div>
			<div class="col-sm-offset-2 col-sm-8" class="share-div">
				<div class="panel panel-default">
					<div class="panel-heading">
						投票先をシェアしよう！
					</div>
					<div class="panel-body">
						<span class="help-block">*一日に一票投票することが出来ます</span>
						<div class="sharebtns-div">
							<p>
								<?php sharebtn_twitter($share_text, $share_uri, TRUE, TRUE) ?>
							</p>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i>コピペ用</span>
							<input id="share-text" type="text" class="form-control" value="<?= $share_text . ' ' . $share_uri ?>">
							<span class="input-group-btn">
								<!--button id="copy-btn" class="btn btn-default disabled" data-toggle="tooltip" data-placement="top" title="クリップボードにコピー">
									<i class="glyphicon glyphicon-file"></i>
								</button-->
							</span>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>

	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="items-div">
			<div class="itembox-div" data-toggle="buttons-radio">
				<?php
				if (TRUE)
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
									<div class="panel-body">
										<div class="row">
											<div class="col-xs-3 col-sm-2 select-btn-div">
												<?php
												if (!$survey->is_voted() || $i == $survey->selected)
												{
													?> 
													<button type="button" id="item<?= $i ?>" name="<?= $i ?>" 
													<?= attr_tooltip_selectform($i, $survey) ?> 
																	class="btn btn-block btn-item btn-lg btn-default<?= attr_class_selectform($i, $survey, $select) ?>">　
														<?= tag_icon_selectform($i, $survey->selected, $select) ?>　
													</button>
													<?php
												}
												?>
											</div>
											<div class="col-xs-9 col-sm-10 select-value-div">
												<span><?= $item->value ?></span>
											</div>
										</div>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
					<?php
				} else
				// is img survey
				{

					$sum_cn = 0;
					foreach ($survey->items as $item)
					{
						$i = $item->index;
						$cn = 6; //calc_item_col($i, count($survey->items));
						// btn state define page loaded start view
						// 
						// get attrs
						if ($sum_cn % 12 == 0)
						{
							?>
							<div class="row">
								<?php
							}
							?>
							<div class="col-sm-<?= $cn ?>">
								<div class="panel panel-itmeselect">
									<div class="panel-body">
										<span><?= $item->value ?></span>
										<?php
										if (!$survey->is_voted() || $i == $survey->selected)
										{
											?> 
											<button type="button" id="item<?= $i ?>" name="<?= $i ?>" 
											<?= attr_tooltip_selectform($i, $survey) ?> 
															class="btn btn-item btn-lg btn-default<?= attr_class_selectform($i, $survey, $select) ?>">　
												<?= tag_icon_selectform($i, $survey->selected, $select) ?>　
											</button>
											<?php
										}
										?> 
									</div>
								</div>
							</div>
							<?php
							$sum_cn += $cn;
							if ($sum_cn % 12 == 0)
							{
								?>
							</div>
							<?php
						}
					}
				}
				?>
			</div>

			<?php
			if ($user->is_guest)
			{
				?>
				<div class="well">
					<p>ゲストユーザーです</p>
					<span class="help-block">*ゲストユーザだと最近の投票を確認することが出来ません <a <?= attr_href(PATH_LOGIN) ?> class="btn btn-info">ログインする</a></span>

				</div>
				<?php
			}
			?>
		</div>
	</div>

	<div class="row">
		<?php
		if (!$survey->is_voted())
		{
			// is_login
			?>
			<form action="<?= base_url("survey/regist/{$survey->id}") ?>" method="POST">
				<!--div class="col-sm-offset-2 col-sm-6" id="text-div">
					<textarea name="vote-text" id="vote-textarea" rows="3"></textarea>
				</div-->
				<div class="col-sm-offset-2 col-sm-8" id="submit-div">
					<input type="hidden" id="vote-value" name="<?= POST_VALUE_NAME ?>" />
					<input type="hidden" name="token" value="<?= $token ?>" />
					<button type="submit" id="submit-main" class="btn btn-primary btn-lg btn-block btn-success disabled">投票する</button>
				</div>
			</form>
			<?php
		} else
		{
			?>

			<div class="col-sm-offset-2 col-sm-8 abutton">
				<a <?= attr_href(PATH_VIEW, $survey->id) ?> class="btn btn-success btn-lg btn-block">
					<i class="<?= ICON_RESULT ?>"></i>
					この投票の結果を見る
				</a>
			</div>
			<?php
		}
		?>
		<!--iframe name="hide-frame" class="no-display"></iframe-->
	</div>
</div>
