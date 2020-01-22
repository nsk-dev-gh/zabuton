<!DOCTYPE html>
<html>
<head>
	<title>回答：<?= $answerData['answer']; ?></title>
	<?= $this->element('include'); ?>
	<meta property="og:title" content="回答：<?= $answerData['answer']; ?>｜ひとこと大喜利「ザブトン」" />
	<meta property="og:url" content="<?= $url; ?>" />
	<meta property="og:image" content="<?= $ogpUrl; ?>" />
	<meta property="og:site_name" content="ひとこと大喜利「ザブトン」" />
	<meta name="twitter:card" content="summary_large_image" />
</head>
<body>
	<div class="wrapper">
		<?= $this->element('header'); ?>
		<div class="main_container">
			<div class="input_area">
				<div class="theme_text">お題で一言</div>
				<?php if($odaiData["type"] == ODAI_TYPE_TEXT): ?>
					<!-- 文字お題 -->
					<div class="text_odai"> 
					<?= $odaiData['text']; ?>
				<?php else: ?>
					<!-- 画像お題 -->
					<div class="img_odai"> 
					<?= $this->Html->image('odai_img/'.$odaiData['img_url']); ?>
				<?php endif; ?>
				</div>
				<div class="answer_input">
					<textarea rows="4" cols="40" placeholder="ボケを入力してください" readonly><?= $answerData['answer']; ?></textarea>
				</div>
			</div>
			<div class="share_area">
				<div class="share_text">＼　シェアする　／</div>
				<ul class="share_button_area">
					<!-- <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$url?>"> -->
						<!-- <li class="share_button_fb"> -->
							<?php // echo $this->Html->image('icon_fb.svg'); ?>
						<!-- </li> -->
					<!-- </a> -->
					<!-- <a href="line://msg/TEXT/<?=$url?>"> -->
						<!-- <li class="share_button_ln"> -->
							<?php // $this->Html->image('icon_ln.svg'); ?>
						<!-- </li> -->
					<!-- </a> -->
					<a href="#">
						<li class="share_button_cp" id="url_copy">
							<div id="copy-value" data-clipboard-text="<?=$url;?>">
								<?= $this->Html->image('icon_cp.svg'); ?>
							</div>
						</li>
					</a>
					<a href="https://twitter.com/intent/tweet?url=<?=$url?>&hashtags=ザブトン,大喜利,お題No_<?=$odaiData['id']?>">
						<li class="share_button_tw"><?= $this->Html->image('icon_tw.svg'); ?></li>
					</a>
				</ul>
			</div>
			<div class="again_area">
				<a href="/input?i=<?= $odaiData['id']; ?>">
					<div class="submit_button">
						このお題でボケる
					</div>
				</a>
			</div>
		</div>
		<?= $this->element('footer'); ?>
	</div>
	<style type="text/css">
		.copy-value {
		  cursor: pointer;
		  position: relative;
		}
		 
		/* Tooltip */
		.tooltip::after {
		    content: 'Copied!';
		    background: #727c7c;
		    display: inline-block;
		    color: #fff;
		    border-radius: .4rem;
		    position: absolute;
		    left: 50%;
		    bottom: -.8rem;
		    transform: translate(-50%, 0);
		    font-size: .75rem;
		    padding: 4px 10px 6px 10px;
		    animation: fade-tooltip .5s 1s 1 forwards;
		}
		 
		/* Animation */
		@keyframes fade-tooltip {
		  to { opacity: 0; }
		}
	</style>
	<?= $this->Html->script('clipboard.min'); ?>
	<script type="text/javascript">
		// タップでコピー
		new ClipboardJS('#copy-value');
		const clipboard = new ClipboardJS('#copy-value');
		// Select all .copy-value items
		const btns = document.querySelectorAll('#copy-value');


		function clearTooltip(e) {
			e.currentTarget.setAttribute('id', 'copy-value');
		}
		// Add .tooltip class when it's clicked
		function showTooltip(elem) {
			elem.setAttribute('class', 'copy-value tooltip');
		}
		clipboard.on('success', function(e) {
			showTooltip(e.trigger);
		});
	</script>
</body>
</html>