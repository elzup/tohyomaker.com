<?php
/* @var $survey Surveyobj */
/* @var $user Userobj */
//echo '<pre>';
//var_dump($survey);
//die('END');
?>

<div class="container">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8" id="items-div">
			<div class="itembox-div" data-toggle="buttons-radio">
				<?php
				if ($user->is_guest)
				{
					?>
					<div class="well">
						<p>ゲストユーザーです</p>
						<span class="help-block">*ゲストユーザだと最近の投票を確認することが出来ません <a <?= attr_href(HREF_TYPE_LOGIN)?> class="btn btn-info">ログインする</a></span>
						
					</div>
					<?php
				}
				?>
				<?php
				if (!$survey->is_voted())
				{
					?>
					<div class="row">
						<div class="col-sm-3">
							↓投票先にチェック
						</div>
					</div>
				<?php }
				?>
				<ul>
					<?php
					foreach ($survey->items as $item)
					{
						$i = $item->index;
						// btn state define page loaded start view
						$add_class = '';
						if ($survey->is_voted())
						{
							$add_class .= ' disabled';
						}
						$icon_tag = tag_icon(' ');
						if ((isset($select) && $i === $select) || $survey->selected === $i)
						{
							$add_class .= ' active';
							$icon_tag = tag_icon(ICON_OK);
						}
						?>
						<li>
							<div class="row">
								<div class="col-sm-2">
									<button type="button" id="item<?= $i ?>" name="<?= $i ?>" class="btn btn-item btn-lg btn-block btn-default<?= $add_class ?>">　<?= $icon_tag ?>　</button>
								</div>
								<div class="col-sm-8">
									<span><?= $item->value ?></span>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
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


			$selected_item = $survey->get_selected_item();
			$share_uri = base_url(PATH_VOTE . $survey->id);
			$share_text = totext_share_voted($selected_item->value, $survey->title);
			?>
			<div class="col-sm-offset-2 col-sm-8" id="selectend-div">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?= totext_voted($selected_item->value) ?></h3>
					</div>
					<div class="panel-body">
						<span class="help-block">*一日に一票投票することが出来ます</span>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i>コピペ用</span>
							<input id="share-text" type="text" class="form-control" value="<?= $share_text . ' ' . $share_uri ?>">
							<span class="input-group-btn">
								<!--button id="copy-btn" class="btn btn-default disabled" data-toggle="tooltip" data-placement="top" title="クリップボードにコピー">
									<i class="glyphicon glyphicon-file"></i>
								</button-->
							</span>
						</div>
						<div class="sharebtns-div">
							<p>
								<?php sharebtn_twitter($share_text, $share_uri) ?>
							</p>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
			<div class="col-sm-offset-2 col-sm-8">
					<a <?= attr_href(HREF_TYPE_VIEW, $survey->id) ?> class="btn btn-success btn-lg btn-block">
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
