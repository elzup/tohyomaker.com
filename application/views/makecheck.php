<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-sm-8" id="tagbox-div">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" action="make/regist" method="POST">
						<fieldset>
							<legend>投票作成確認</legend>
							<div class="form-group">
								<label for="owner" class="col-lg-2 control-label">作成者</label>
								<div class="col-lg-10">
									<div
										<input type="hidden" class="form-control" id="owner-issecret" value="<?= $user->screen_name ?>" disabled="">
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?= $user->screen_name ?>
											</div>
										</div>
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
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?= $data['title'] ?>
											</div>
										</div>
										<input type="hidden" class="form-control" name="title" id="title" placeholder="必須">
									</div>
								</div>

								<div class="form-group">
									<label for="description" class="col-lg-2 control-label">説明</label>
									<div class="col-lg-10">
										<textarea class="form-control" name="description" rows="2" id="description"></textarea>
									</div>
								</div>

								<div class="form-group">
									<label for="item1" class="col-lg-2 control-label">項目</label>
									<div class="col-lg-10">
										<?php
										for ($i = 1; $i <= 5; $i++)
										{
											if (!isset($data["item{$i}"]))
												continue;
											?>
											<div class="panel panel-default panel-check">
												<div class="panel-body">
													<?= $data["item{$i}"] ?>
												</div>
											</div>
											<input type="hidden" name="item<?= $i ?>" id="item1" class="form-control" />
										<?php } ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-2 control-label">集計ポイント</label>
									<div class="col-lg-10">
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?php
												$text = array(
														'a' => '1時間後に集計結果を記録して残します',
														'b' => '24時間後に集計結果を記録して残します',
												);
												echo $text[$data['timing']];
												?>
											</div>
										</div>
										<input type="hidden" name="timing" id="timing" class="form-control" value="<?= $data['timing'] ?>" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="tag" class="col-lg-2 control-label">タグ</label>
								<div class="col-lg-10">
									<div class="panel panel-default panel-check">
										<div class="panel-body">
											<p>
												<?php
												if (isset($data['tag']))
												{
													$tags = explode(',', $data['tags']);
													foreach ($tas as $tag)
													{
														?>
														<button type="button" class="btn btn-primary btn-xs disabled"><?= $tag ?></button>
														<?php
													}
												} else
												{
													echo 'no tag';
												}
												?>
											</p>
											<?= $data['title'] ?>
										</div>
									</div>
									<input type="hidden" class="form-control" name="tag" id="tag" value="<?= $data['tag'] ?>">
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
</div>



































































