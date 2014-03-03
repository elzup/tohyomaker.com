<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8" id="tagbox-div">
			<div class="well">
				<form class="form-horizontal" action="check" method="POST">
					<fieldset>
						<legend>作成フォーム</legend>
						<div class="form-group">
							<label for="owner" class="col-lg-2 control-label">作成者</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="owner-issecret" value="<?= $user->screen_name ?>" disabled="">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="is_anonymous">匿名(作者非公開)
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="title" class="col-lg-2 control-label">タイトル</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="title" id="title" placeholder="必須">
								<span class="help-block">ex.)きのこたけのこ人気投票</span>
							</div>
						</div>

						<div class="form-group">
							<label for="description" class="col-lg-2 control-label">説明</label>
							<div class="col-lg-10">
								<textarea class="form-control" name="description" rows="2" id="description"></textarea>
								<span class="help-block">ex.)きのこの山とたけのこの里好きな方に投票してください。</span>
							</div>
						</div>

						<div class="form-group">
							<label for="item1" class="col-lg-2 control-label">項目</label>
							<div class="col-lg-10">
								<?php for ($i = 1; $i <= 10; $i++) {?>
								<div class="input-group">
									<input type="text" name="item<?=$i?>" id="item<?=$i?>" class="form-control" />
									<span class="input-group-btn">
										<button class="btn btn-danger btn-diswitch-off" type="button"><i class="glyphicon glyphicon-remove"></i></button>
									</span>
								</div>
								<button class="btn btn-success btn-diswitch-on" type="button" style="display: none;"><i class="glyphicon glyphicon-plus"></i></button>
								<?php }?>
								<span class="help-block">ex.)きのこの山</span>
								<span class="help-block">ex.)たけのこの里</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">集計ポイント</label>
							<div class="col-lg-10">
								<div class="radio">
									<label>
										<input type="radio" name="timing" id="radio-a" value="a" checked>
										1日後
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="timing" id="radio-b" value="b">
										1時間後
									</label>
								</div>
								<span class="help-block">集計をするタイミングを選んで下さい</span>
							</div>
						</div>

						<div class="form-group">
							<label for="tag" class="col-lg-2 control-label">タグ</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="tag" id="tag">
								<span class="help-block">ex.)お菓子,定番,二択 カンマ区切りで指定</span>
							</div>
						</div>

						<input type="hidden" name="id_user" value="<?= $user->id ?>">
						<input type="hidden" name="token" value="<?= $token ?>">
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button class="btn btn-default">Cancel</button>
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>