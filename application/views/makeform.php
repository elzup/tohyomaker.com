<?php
/* @var $user Userobj */
?>

<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8" id="makeform-div">
			<div class="well">
				<?php
				if (!$user->is_guest)
				{
					//logined
					?>

					<form class="form-horizontal" action="<?= base_url(PATH_MAKECHECK) ?>" method="POST">
						<fieldset>
							<legend>作成フォーム</legend>

							<?php
							if (!empty($post))
							{
								?>
								<div class="row margin-bottom">
									<div class="col-sm-8 col-sm-offset-2 btn-middle">
										<a href="<?= base_url(PATH_MAKEDESTROY) ?>" class="btn btn-lg btn-block btn-warning">内容をクリアする</a>
									</div>
								</div>
								<?php
							}
							?>

							<div class="form-group">
								<label for="owner" class="col-lg-2 control-label">作成者</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="sur-owner-issecret" value="<?= $user->screen_name ?>" disabled="">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="is_anonymous">匿名(作者非公開)
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">タイトル</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="title" id="sur-title" value="<?= isset_just(@$post['title']) ?>" placeholder="必須" maxlength="30">
									<span class="help-block">ex.)きのこたけのこ人気投票</span>
								</div>
							</div>

							<div class="form-group">
								<label for="description" class="col-lg-2 control-label">説明</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="description" id="sur-description" value="<?= isset_just(@$post['description']) ?>" maxlength="30">
									<span class="help-block">ex.)「好きな方」に投票！</span>

									<div class="checkbox">
										<label><input type="checkbox" name="is-image-checkbox" id="is-image-checkbox">画像をつける</label>
									</div>
									<input type="text" class="form-control" name="description-image" id="sur-description-image" value="<?= isset_just(@$post['description-image']) ?>" maxlength="50">
									<span class="help-block">特定の画像URLを指定すると説明文の下に画像を表示することが出来ます</span>
									<span class="help-block">対応している画像サービス
										<ul>
											<!--<li>Twitter ex.)pic.twitter.com/xxxxxx</li>-->
											<li>Twitpic ex.)twitpic.com/xxxxxx</li>
											<!--<li>yfrog ex.)yfrog.com/xxxxxx</li>-->
											<li>Twitgoo ex.)twitgoo.com/xxxxxx</li>
											<li>img.ly ex.)img.ly/xxxxxx</li>
											<li>ついっぷる ex.)p.twipple.jp/xxxxxx</li>
										</ul>
									</span>

								</div>
							</div>

							<div class="form-group">
								<label for="item1" class="col-lg-2 control-label">項目</label>
								<div class="col-lg-8">
									<?php
									for ($i = 1; $i <= 10; $i++)
									{
										?>
										<input type="text" name="item<?= $i ?>" id="sur-item<?= $i ?>" class="form-control" value="<?= isset_just(@$post['item' . $i]) ?>" maxlength="20">
									<?php } ?>
									<span class="help-block">ex.)きのこの山</span>
									<span class="help-block">ex.)たけのこの里</span>
								</div>
							</div>

							<div class="form-group">
								<label for="timing" class="col-lg-2 control-label">集計時間</label>
								<?php
								$timing = @$post['timing'];
								$timing_lib = ['0_0' => '無し', '0_1' => '1時間', '0_3' => '3時間', '1_0' => '1日', '3_0' => '3日', '7_0' => '1週間'];
								?>
								<input type="hidden" name="timing" id="timing" value="<?= $timing ? : '0_0' ?>" />
								<div class="btn-group timing col-lg-8" data-toggle="buttons-radio">

									<?php
									foreach ($timing_lib as $key => $value)
									{
										?>
										<button type="button" v="<?= $key ?>" class="btn btn-default<?= ($timing == $key || (empty($timing) && $key == '0_0')) ? ' active' : '' ?>"><?= $value ?></button>
									<?php } ?>
								</div>
								<div class="col-lg-offset-2">
									<span class="help-block">一度その時間での集計結果を記録するタイミングを設定できます。投票は締め切りません</span>
								</div>
							</div>

							<div class="form-group">
								<label for="tag" class="col-lg-2 control-label">タグ</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="tag" id="sur-tag" value="<?= isset_just(@$post['tag']) ?>" maxlength="50">
									<span class="help-block">ex.)お菓子,定番,二択 カンマ区切りで指定</span>
									<span class="help-block">*一つのタグは最大20文字</span>
								</div>
							</div>

							<input type="hidden" autocomplete="off" name="id_user" value="<?= $user->id ?>">
							<div class="form-group">
								<div class="col-lg-8 col-lg-offset-2 submit-btns">
									<div class="row">
										<div class="col-sm-6 abutton">
											<a href="<?= base_url(PATH_MAKEDESTROY) ?>" class="btn btn-lg btn-block btn-warning">クリア</a>
											<!--a href="javascript:window.history.back();" class="btn btn-block btn-default">変更</a-->
										</div>
										<div class="col-sm-6">
											<button type="submit" id="submit-main" class="btn btn-lg btn-block btn-success disabled">作成</button>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>

					<?php
				} else
				// no login
				{
					?>
					<div class="align-center">
						<span class="help-block">*投票の作成にはTwitterアカウントでログインが必要です</span>
						<span class="help-block">*認証後勝手にツイートする、フォローするという事はありません</span>
						<div class="btn-middle"><a <?= attr_href(PATH_LOGIN) ?> class="btn btn-info btn-lg">ログインする</a></div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>