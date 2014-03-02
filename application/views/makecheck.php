<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-sm-8" id="tagbox-div">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" action="../regist" method="POST">
						<fieldset>
							<legend>投票作成確認</legend>
							<div class="form-group">
								<label for="owner" class="col-lg-2 control-label">作成者</label>
								<div class="col-lg-10">
									<div
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?= $user->screen_name . (isset($data['is?anonymous']) ? '非公開' : "") ?>
											</div>
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
									</div>
								</div>

								<div class="form-group">
									<label for="description" class="col-lg-2 control-label">説明</label>
									<div class="col-lg-10">
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?= $data['description'] ?>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="item1" class="col-lg-2 control-label">項目</label>
									<div class="col-lg-10">
										<?php
										for ($i = 1; $i <= 5; $i++)
										{
											if (empty($data["item{$i}"]))
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
													$tags = explode(',', $data['tag']);
													foreach ($tags as $tag)
													{
														if (empty($tag))
															continue;
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
										</div>
									</div>
								</div>
							</div>

							<input type="hidden" name="is_anonymous" value="<?= isset($data['is_anonymous']) ? 't' : 'f' ?>">
							<input type="hidden" name="title" value="<?= $data['title'] ?>">
							<input type="hidden" name="description" value="<?= $data['description'] ?>"></textarea>
							<input type="hidden" name="timing" value="<?= $data['timing'] ?>" />
							<input type="hidden" name="tag" value="<?= $data['tag'] ?>">

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
