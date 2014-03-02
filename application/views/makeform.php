<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-sm-8" id="tagbox-div">
			<div class="well">
				<form class="form-horizontal" action="check" method="POST">
					<fieldset>
						<legend>作成フォーム</legend>
						<div class="form-group">
							<label for="owner" class="col-lg-2 control-label">作成者</label>
							<div class="col-lg-10">
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
								<input type="text" name="item1" id="item1" class="form-control" />
								<input type="text" name="item2" id="item2" class="form-control" />
								<input type="text" name="item3" id="item3" class="form-control" />
								<input type="text" name="item4" id="item4" class="form-control" />
								<input type="text" name="item5" id="item5" class="form-control" />
								<span class="help-block">ex.)きのこ</span>
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