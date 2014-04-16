<?php
foreach ($data as &$datum)
{
	$datum = h($datum);
}
?>
<div class="container">
	<!-- TODO: include check js file-->
	<div class="row">
		<div class="col-lg-offset-2 col-sm-8" id="makecheck-div">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" action="<?= base_url(HREF_TYPE_MAKEREGIST) ?>" method="POST">
						<fieldset>
							<legend>投票作成確認</legend>
							<div class="form-group">
								<label for="owner" class="col-lg-2 control-label">作成者</label>
								<div class="col-lg-10">
									<div
										<div class="well well-check">
												<?= $user->screen_name . (isset($data['is_anonymous']) ? '(非公開)' : "") ?>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="title" class="col-lg-2 control-label">タイトル</label>
									<div class="col-lg-10">
										<div class="well well-check">
											<?= $data['title'] ?>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="description" class="col-lg-2 control-label">説明</label>
									<div class="col-lg-10">
										<div class="well well-check">
											<?= $data['description'] ?>に投票！
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
											<div class="well well-check">
												<?= $data["item{$i}"] ?>
											</div>
										<input type="hidden" autocomplete="off" name="item<?= $i ?>" class="form-control" value="<?= $data["item{$i}"] ?>">
										<?php } ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-2 control-label">集計時間</label>
									<div class="col-lg-10">
										<div class="well">
											<?php
											$timing = (($data['timing-d'] ? $data['timing-d'] . '日' : '') . ($data['timing-h'] ? $data['timing-h'] . '時間' : ''));
											$timing = $timing ? $timing . '後に一度集計記録します' : '無し';
											?>
											<p><?= $timing ?> </p>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="tag" class="col-lg-2 control-label">タグ</label>
									<div class="col-lg-10">
										<div class="well well-check">
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
														<button type="button" class="btn btn-success btn-xs disabled"><?= $tag ?></button>
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

								<input type="hidden" autocomplete="off" name="is_anonymous" value="<?= isset($data['is_anonymous']) ? '1' : '0' ?>">
								<input type="hidden" autocomplete="off" name="title"        value="<?= $data['title'] ?>">
								<input type="hidden" autocomplete="off" name="description"  value="<?= $data['description'] ?>">
								<input type="hidden" autocomplete="off" name="timing"    	 value="<?= $data['timing-d'] . ',' . $data['timing-h'] ?>">
								<input type="hidden" autocomplete="off" name="tag"          value="<?= $data['tag'] ?>">

								<input type="hidden" autocomplete="off" name="id_user" value="<?= $user->id ?>">
								<input type="hidden" autocomplete="off" name="token"   value="<?= $token ?>">

								<div class="form-group">
									<div class="col-lg-10 col-lg-offset-2 submit-btns">
										<div class="row">
											<div class="col-sm-6">
												<a href="<?=  base_url('make')?>" class="btn btn-block btn-default">変更</a>
												<!--a href="javascript:window.history.back();" class="btn btn-block btn-default">変更</a-->
											</div>
											<div class="col-sm-6">
												<button type="submit-main" class="btn btn-block btn-success">作成</button>
											</div>
										</div>

									</div>
								</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
 	</div>
</div>
