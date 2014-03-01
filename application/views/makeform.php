			<div class="container">
        <div class="row">
          <div id="title-div" class="col-sm-10">
            <h1 id="title-str">投票作成</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6" id="tagbox-div">
            <div class="well">
              <form class="form-horizontal">
                <fieldset>
                  <legend>作成フォーム</legend>
                  <div class="form-group">
                    <label for="owner" class="col-lg-2 control-label">作成者</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="owner" placeholder="必須">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="">匿名(作者非公開)
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="owner-issecret" class="col-lg-2 control-label">作成者</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="owner-issecret" placeholder="必須">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="title" class="col-lg-2 control-label">タイトル</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="title" placeholder="必須">
                      <span class="help-block">ex.)サザエさん人気キャラ投票</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">説明</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" rows="2" id="description"></textarea>
                      <span class="help-block">ex.)好きなキャラに投票してください。</span>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="item1" class="col-lg-2 control-label">項目</label>
                    <div class="col-lg-10">
                      <input type="text" name="item1" id="item1" class="form-control" />
                      <span class="help-block">ex.)サザエさん,波平</span>
                      <input type="text" name="item2" id="item2" class="form-control" />
                      <input type="text" name="item3" id="item3" class="form-control" />
                      <input type="text" name="item4" id="item4" class="form-control" />
                      <input type="text" name="item5" id="item5" class="form-control" />
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