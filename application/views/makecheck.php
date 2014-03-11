<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8" id="tagbox-div">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" action="<?= base_url('make/regist') ?>" method="POST">
						<fieldset>
							<legend>投票作成確認</legend>
							<div class="form-group">
								<label for="owner" class="col-lg-2 control-label">作成者</label>
								<div class="col-lg-10">
									<div
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?= $user->screen_name . (isset($data['is_anonymous']) ? '(非公開)' : "") ?>
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
									<label for="target" class="col-lg-2 control-label">対象</label>
									<div class="col-lg-10">
										<div class="panel panel-default panel-check">
											<div class="panel-body">
												<?= (!isset($data['target']) ? '全員': $data['target']) ?>
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
										for ($i = 1; $i <= 10; $i++)
										{
											if (empty($data["item{$i}"]))
											{
												continue;
											}
											?>
											<div class="panel panel-default panel-check">
												<div class="panel-body">
													<?= $data["item{$i}"] ?>
												</div>
											</div>
											<input type="hidden" name="item<?= $i ?>" class="form-control" value="<?= $data["item{$i}"] ?>">
										<?php } ?>
									</div>
								</div>

								<!--div class="form-group">
									<label class="col-lg-2 control-label">集計期間</label>
									<div class="col-lg-10">
										<div class="panel panel-default panel-check">
											<div class="panel-body">
								<?php
								$text = array(
										'a' => ' 1時間で締め切ります',
										'b' => '24時間で締め切ります',
								);
								echo $text[$data['timing']];
								?>
											</div>
										</div>
									</div>
								</div-->

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
															{
																continue;
															}
															?>
																<button type="button" class="btn btn-primary btn-xs disabled"><?= $tag ?></button>
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

								<input type="hidden" name="is_anonymous" value="<?= isset($data['is_anonymous']) ? '1' : '0' ?>">
								<input type="hidden" name="title"        value="<?= $data['title'] ?>">
								<input type="hidden" name="target"       value="<?= $data['target'] ?>">
								<input type="hidden" name="description"  value="<?= $data['description'] ?>">
								<!--input type="hidden" name="timing"    value=""-->
								<input type="hidden" name="tag"          value="<?= $data['tag'] ?>">

								<input type="hidden" name="id_user" value="<?= $user->id ?>">
								<input type="hidden" name="token"   value="<?= $token ?>">

								<div class="form-group">
									<div class="col-lg-10 col-lg-offset-2">
										<a href="javascript:window.history.back();" class="btn btn-default">変更</a>

										<button type="submit-main" class="btn btn-primary">作成</button>
									</div>
								</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
 	</div>
</div>
