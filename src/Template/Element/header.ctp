		<header>
			<span class="logo">
				<a href="/index">
					<?= $this->Html->image('logo.png'); ?>
				</a>
			</span>
			<span class="login">
				<!-- お題を募集 -->
			</span>
		</header>
		<nav>
			<ul class="header_menu">
				<li><a href="/img_odai_list" class="">画像お題</a></li>
				<li><a href="/text_odai_list" class="">文字お題</a></li>
				<li><a href="#" class="" id="js-show-popup">お題を登録</a></li>
			</ul>
		</nav>
		<div class="popup" id="js-popup">
		  <div class="popup-inner">
		  	<!-- popup inner -->
		  	<div class="tabs">
			    <input id="all" type="radio" name="tab_item" checked>
			    <label class="tab_item" for="all">文字お題</label>
			    <input id="img_tab" type="radio" name="tab_item">
			    <label class="tab_item" for="img_tab">画像お題</label>
			    <!-- 文字お題登録 -->
			    <div class="tab_content" id="all_content">
			    	<?= $this->Form->create(null, ['url' => ['action' => 'registTextOdai'], 'name' => 'text_odai']); ?>
				    	<div class="tab_input_area">
					        <div class="theme_text">
						        文字でお題を登録する
					        </div>
					        <div class="answer_input">
								<textarea name="text_odai" rows="4" cols="40" placeholder="ボケを入力してください"></textarea>
							</div>
				    	</div>
						<div class="submit_area">
							<a href="javascript:text_odai.submit()">
								<div class="submit_button">
									登録
								</div>
							</a>
						</div>
			    	</form>
			    	<?= $this->Form->end(); ?>
			    </div>
			    <!-- 画像お題登録 -->
			    <div class="tab_content" id="img_tab_content">
			        <?= $this->Form->create(null, ['url' => ['action' => 'regist_image_odai'], 'name' => 'img_odai', 'type' => 'file']); ?>
				    	<div class="tab_input_area">
					        <div class="theme_text">
						        画像でお題を登録する
					        </div>
					        <label>
					        	<div class="image_input_image">
									<img id="preview" accept="image/*" src="/img/add.png">
							        <input type="file" name="odaiImg" id="odaiImg" accept="image/png,image/jpeg">							        
							    </div>
					        	<div class="image_input_text">
						        	ファイルを選択
					        	</div>
					        </label>
				    	</div>
						<div class="submit_area">
							<a href="javascript:img_odai.submit()">
								<div class="submit_button">
									登録
								</div>
							</a>
						</div>
			    	</form>
			    	<?= $this->Form->end(); ?>
				</div>
		  	</div>
		  </div>
		  <div class="black-background" id="js-black-bg"></div>
		</div>
		<?= $this->Html->script('popup'); ?>