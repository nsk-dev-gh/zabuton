<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Imagine;

define('ODAI_TYPE_TEXT', 1);
define('ODAI_TYPE_IMAGE', 2);
define('DELETE_FLG_DISABLE', 0);
class PagesController extends AppController
{

	public function beforeFilter(Event $event){
        // $this->autoLayout = false;	
        $this->viewBuilder()->enableAutoLayout(false);
	}

	public function test(){
		$odaiId = 26;
    	$answer = "1234567890123456789012345678901234567890";
    	// お題タイプ確認
		$odaiT = TableRegistry::get('Odai');
		$odaiData = $odaiT->getData(['id' => $odaiId]);
    	$type = $odaiData["type"];

		// 画像回答の場合
    	$baseImg = imagecreatefrompng(WWW_ROOT.'img/ogp_img.png');
		$baseImg = $this->imgAdjust($baseImg, $odaiData["img_url"]);
		// アンサーを追加
		if (!empty(strstr($answer, PHP_EOL))) {
			$baseImg = $this->eolSizeAdjust($baseImg, $answer, 0, [500, 270, 240, 1800, 1.0]);
		}else{
			$baseImg = $this->sizeAdjust($baseImg, $answer, 0, [12, 24, 27, 500, 270, 240, 1800, 1.0 ]);
		}

		// 出力
		header('Content-Type: image');
    	imagepng($baseImg);
    	exit;

	}


    public function index() {

    }

    public function imgOdaiList() {
		$odaiT = TableRegistry::get('Odai');
    	$odaiList = $odaiT->getNewListOrderDesc(18, DELETE_FLG_DISABLE, 1, ["type" => ODAI_TYPE_IMAGE]);
		$possibleFlg = 1;
    	if ($odaiList->count() < 18) {
	    	$possibleFlg = 0;
    	}
    	$this->set(compact('odaiList', 'possibleFlg'));
    }

    public function moreImgOdaiList(){
		// viewを利用しない
        // $this->viewBuilder()->enableAutoLayout(false);
		$this->autoRender = false;
		$page = $this->request->getQuery("p");
		if (empty($page)) {
			$this->response->body(["error" => "NoPager"]);
		}
		// コンテンツ取得
		$odaiT = TableRegistry::get('Odai');
    	$odaiList = $odaiT->getNewListOrderDesc(18, DELETE_FLG_DISABLE, $page, ["type" => ODAI_TYPE_IMAGE]);
		// 空だったら返却
		if (empty($odaiList->toArray())) {
			$this->response->body(["error" => "NoOdaiList"]);
		}
		// html生成
		$html = "";
		foreach ($odaiList as $key => $value) {
			$html .=
			'<a href="/input?i='.$value['id'].'">
				<li>
					<img src="/img/odai_img/'.$value['img_url'].'"
				</li>
			</a>';
		}
		$this->response->body($html);
		return;    	
    }

    public function textOdaiList() {
		$odaiT = TableRegistry::get('Odai');
    	$odaiList = $odaiT->getNewListOrderDesc(20, DELETE_FLG_DISABLE, 1, ["type" => ODAI_TYPE_TEXT]);
		$possibleFlg = 1;
    	if ($odaiList->count() < 20) {
	    	$possibleFlg = 0;
    	}
    	$this->set(compact('odaiList', 'possibleFlg'));
    }

    public function moreTextOdaiList(){
		// viewを利用しない
        // $this->viewBuilder()->enableAutoLayout(false);
		$this->autoRender = false;
		$page = $this->request->getQuery("p");
		if (empty($page)) {
			$this->response->body(["error" => "NoPager"]);
		}
		// コンテンツ取得
		$odaiT = TableRegistry::get('Odai');
    	$odaiList = $odaiT->getNewListOrderDesc(20, DELETE_FLG_DISABLE, $page, ["type" => ODAI_TYPE_TEXT]);
		// 空だったら返却
		if (empty($odaiList->toArray())) {
			$this->response->body(["error" => "NoOdaiList"]);
		}
		// html生成
		$html = "";
		foreach ($odaiList as $key => $value) {
			$html .=
			'<a href="/input?i='.$value['id'].'">
				<li>
					'.$value['text'].'
				</li>
			</a>';
		}
		$this->response->body($html);
		return;    	
    }


    public function input() {
    	$odaiId = $_GET['i'];
		$odaiT = TableRegistry::get('Odai');
		$odaiData = $odaiT->getData(['id' => $odaiId]);
    	$url = "https://".$_SERVER["HTTP_HOST"]."/input?i=".$odaiId;
		$ogpUrl = "https://".$_SERVER["HTTP_HOST"].$odaiData['ogp_img_url'];
    	$this->set(compact('odaiData', 'url', 'ogpUrl'));
    }

    public function confirm(){
    	$odaiId = $_GET['odaiId'];
    	$question = $_GET['question'];
    	$answer = $_GET['answer'];
    	if (empty($answer)) { // 空なら返す
	        return $this->redirect(['action' => 'input', 'i' => $odaiId]);
    	}
    	// お題タイプ確認
		$odaiT = TableRegistry::get('Odai');
		$odaiData = $odaiT->getData(['id' => $odaiId]);
		// ないからリダイレクト
		if (empty($odaiData)) {
	        return $this->redirect(['action' => 'input', 'i' => $odaiId]);
		}
    	$type = $odaiData["type"];
    	$baseImg = "";
    	// テキスト回答の場合
    	if ($type == ODAI_TYPE_TEXT) {
			// まずは質問テキスト入れる
			// 改行があるか確認
	    	$baseImg = imagecreatefrompng(WWW_ROOT.'img/ogp_text.png');
			if (!empty(strstr($question, PHP_EOL))) {
				$baseImg = $this->eolSizeAdjust($baseImg, $question);
			}else{
				$baseImg = $this->sizeAdjust($baseImg, $question);
			}
			// 次に質問テキスト入れる
			if (!empty(strstr($answer, PHP_EOL))) {
				$baseImg = $this->eolSizeAdjust($baseImg, $answer, 220);
			}else{
				$baseImg = $this->sizeAdjust($baseImg, $answer, 220);
			}
    	}else{
		// 画像回答の場合
	    	$baseImg = imagecreatefrompng(WWW_ROOT.'img/ogp_img.png');
			$baseImg = $this->imgAdjust($baseImg, $odaiData["img_url"]);
			// アンサーを追加
			if (!empty(strstr($answer, PHP_EOL))) {
				$baseImg = $this->eolSizeAdjust($baseImg, $answer, 0, [500, 270, 240, 1800, 1.0]);
			}else{
				$baseImg = $this->sizeAdjust($baseImg, $answer, 0, [12, 24, 27, 500, 270, 240, 1800, 1.0 ]);
			}
    	}

		// 出力
		$path = '/img/answer_ogp/'.date('YmdHis')."_".substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 20).".png";
		$imgSavePath = WWW_ROOT.$path;
    	imagepng($baseImg, $imgSavePath);

		$answerT = TableRegistry::get('Answer');
		$answerId = $answerT->setData([
			"odai_id" => $odaiId,
			"answer" => $answer,
			"ogp_img_url" => $path
		]);

        return $this->redirect(['action' => 'answer', 'i' => $answerId]);
    }

    public function answer(){
    	$answerId = $_GET['i'];
		$answerT = TableRegistry::get('Answer');
    	$answerData = $answerT->getData(['id' => $answerId]);
    	$odaiId = $answerData['odai_id'];
		$odaiT = TableRegistry::get('Odai');
		$odaiData = $odaiT->getData(['id' => $odaiId]);

		$url = "https://".$_SERVER["HTTP_HOST"]."/answer?i=".$answerId;
		$ogpUrl = "https://".$_SERVER["HTTP_HOST"].$answerData['ogp_img_url'];

		$this->set(compact('answerData', 'odaiData', 'url', 'ogpUrl'));
    }

    public function registTextOdai(){
    	$odai = $_POST['text_odai'];
		$odaiT = TableRegistry::get('Odai');

		$odaiId = $odaiT->setData([
			"type" => ODAI_TYPE_TEXT,
			"text" => $odai
		]);
		$this->generateOdaiOgp($odaiId);

        return $this->redirect(['action' => 'input', 'i' => $odaiId]);
    }

    public function registImageOdai(){
    	// 確認
		$data = $this->request->getData();
		if (!empty($data["odaiImg"]["tmp_name"])){
			// 画像取得
			$url = $data["odaiImg"]["tmp_name"];
			$imagine = new Imagine\Imagick\Imagine();
			$size = new Imagine\Image\Box(500, 500);
			$imagine->open($url)
				->thumbnail($size)
				->save($url);
			// 拡張子を判定
			$imageType = exif_imagetype($url);
			$ext = ""; //拡張子用意
			switch ($imageType) {
				case IMAGETYPE_GIF:
					$ext = ".gif"; break;
				case IMAGETYPE_JPEG:
					$ext = ".jpg"; break;
				case IMAGETYPE_PNG:
					$ext = ".png"; break;
				default:
					// gif,jpg,pngじゃなかったらfalse返却
					return false;
					break;
			}
			// アップロード準備
			$imgData = file_get_contents($url);
			$fileName = date('YmdHis')."_".substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 20).$ext;
		    $res = file_put_contents(WWW_ROOT."img/odai_img/".$fileName, $imgData);
		    if ($res != false) {
				$odaiT = TableRegistry::get('Odai');
				$odaiId = $odaiT->setData([
					"type" => ODAI_TYPE_IMAGE,
					"img_url" => $fileName
				]);
				$this->generateOdaiOgp($odaiId);
		        return $this->redirect(['action' => 'input', 'i' => $odaiId]);
		    }
		}

        return $this->redirect(['action' => 'imgOdaiList']);
    }

	// --------------------
	// private関数
	// --------------------
	private function sizeAdjust($baseImg, $string, $addHeight = 0, $constList = [ 17, 34, 54, 1050, 150, 120, 1200, 0.7 ]) {
		// 文字数をカウントして一番大きいものを出す
		$allStrSize = strlen(mb_convert_encoding($string, 'SJIS', 'UTF-8'));
		$resString = "";
		$expString = array();
		$fontSize = 60;
		// 全角17文字以下
		if ($allStrSize <= ($constList[0]*2)) {
			// 一行で文字サイズ60
			$resString = $string;
			$maxSizeStr = $string;
			$addHeight = $addHeight + 20;
		}else{
			// 全角34文字以下
			if ($allStrSize <= ($constList[1]*2)) {
				// 二行にして文字サイズ60
				$fontSize = 50;
				$expString = str_split(mb_convert_encoding($string, 'SJIS', 'UTF-8'), $allStrSize/2+2);
			// 全角54文字以下
			}elseif ($allStrSize <= ($constList[2]*2)) {
				// 二行にして文字サイズ40
				$expString = str_split(mb_convert_encoding($string, 'SJIS', 'UTF-8'), $allStrSize/2+2);
				$fontSize = 40;
			}else{ // 77文字まで
				// 三行に分割して入るだけフォント小さくする
				$expString = str_split(mb_convert_encoding($string, 'SJIS', 'UTF-8'), $allStrSize/3+2);
			}
			$maxSize = strlen($expString[0]);
			$maxSizeStr = mb_convert_encoding($expString[0], 'UTF-8', 'SJIS');
			// maxサイズが出たら他の文字を中央寄せにする
			foreach ($expString as $key => $value) {
				$strSize = strlen($value);
				if ($maxSize > $strSize ) {
					$spaceNum = ceil(($maxSize/2) - ($strSize/2) + 1) * 1.5;
					for ($i=0; $i < $spaceNum ; $i++) { 
						$expString[$key] = " ".$expString[$key];
					}
				}
				// ついでにUTF8に変換しとく
				$expString[$key] = mb_convert_encoding($value, 'UTF-8', 'SJIS');
			}
			// 文字結合
			$resString = "";
			foreach ($expString as $key => $value) {
				$resString = $resString . $value . "\n";
			}
		}
		// ベース画像読み込み
		$fontColor = imagecolorallocate($baseImg, 54, 54, 54);
		$fontFile = Router::url('/font/NotoSansCJKjp-Regular.otf');
		// ハマるサイズを算出する
		$dim = imagettfbbox($fontSize, 0, $fontFile, $maxSizeStr);
		$textWidth = $dim[4] - $dim[6];
		while ($textWidth >= $constList[3]) {
			$fontSize--;
			$dim = imagettfbbox($fontSize, 0, $fontFile, $maxSizeStr);
			$textWidth = $dim[4] - $dim[6];
		}
		$heightMargin = $constList[4] + $addHeight;
		if (count($expString) >= 3 && $fontSize > 35) {
			$fontSize = 35;
			$dim = imagettfbbox($fontSize, 0, $fontFile, $maxSizeStr);
			$textWidth = $dim[4] - $dim[6];
			$heightMargin = $constList[5] + $addHeight;
		}
		$widthMargin = ($constList[6] - $textWidth)/2;

    	imagefttext(
			$baseImg,
			$fontSize, 
			0,    		// 文字の角度
			$widthMargin,
			$heightMargin,       	
			$fontColor,
			$fontFile,
			$resString, 	// 挿入文字列
			array("linespacing" => $constList[7])
		);    

		return $baseImg;
	}

	private function eolSizeAdjust($baseImg, $string, $addHeight = 0, $constList = [1050, 150, 120, 1200, 0.7]) {
		// 改行で分割する
		$string = str_replace(array("\r\n", "\r", "\n"), "\n", $string);
		$expString = explode("\n", $string);
		// 文字数をカウントして一番大きいものを出す
		$maxSize = 0;
		$maxSizeStr = "";
		foreach ($expString as $key => $value) {
			$strSize = strlen(mb_convert_encoding($value, 'SJIS', 'UTF-8'));
			if ($maxSize < $strSize ) {
				$maxSize = $strSize;
				$maxSizeStr = $value;
			}
		}
		// maxサイズが出たら他の文字を中央寄せにする
		foreach ($expString as $key => $value) {
			$strSize = strlen(mb_convert_encoding($value, 'SJIS', 'UTF-8'));
			if ($maxSize > $strSize ) {
				$spaceNum = ceil(($maxSize/2) - ($strSize/2) + 1) * 1.5;
				for ($i=0; $i < $spaceNum ; $i++) { 
					$expString[$key] = " ".$expString[$key];
				}
			}
		}
		// 文字結合
		$resString = "";
		foreach ($expString as $key => $value) {
			$resString = $resString . $value . "\n";
		}
		// ベース画像読み込み
		$fontSize = 47;
		$fontColor = imagecolorallocate($baseImg, 54, 54, 54);
		$fontFile = Router::url('/font/NotoSansCJKjp-Regular.otf');
		// ハマるサイズを算出する
		$dim = imagettfbbox($fontSize, 0, $fontFile, $maxSizeStr);
		$textWidth = $dim[4] - $dim[6];
		while ($textWidth >= $constList[0]) {
			$fontSize--;
			$dim = imagettfbbox($fontSize, 0, $fontFile, $maxSizeStr);
			$textWidth = $dim[4] - $dim[6];
		}
		$heightMargin = $constList[1] + $addHeight;
		if (count($expString) >= 3 && $fontSize > 35) {
			$fontSize = 35;
			$dim = imagettfbbox($fontSize, 0, $fontFile, $maxSizeStr);
			$textWidth = $dim[4] - $dim[6];
			$heightMargin = $constList[2] + $addHeight;
		}
		$widthMargin = ($constList[3] - $textWidth)/2;

    	imagefttext(
			$baseImg,
			$fontSize, 
			0,    		// 文字の角度
			$widthMargin,
			$heightMargin,       	
			$fontColor,
			$fontFile,
			$resString, 	// 挿入文字列
			array("linespacing" => $constList[4])
		);    

		return $baseImg;
	}

	private function imgAdjust($baseImg, $odaiImgUrl){
		$url = WWW_ROOT.'img/odai_img/'.$odaiImgUrl;
		$imgInfo = getimagesize($url);
    	$odaiImg = "";
    	if ($imgInfo[2] == 2) { //JPEG
	    	$odaiImg = imagecreatefromjpeg($url);
    	}elseif ($imgInfo[2] == 3) { //PNG
	    	$odaiImg = imagecreatefrompng($url);
    	}else{
    		// 許可されてないお題画像
    		return false;
    	}
    	$imgWidth = $imgInfo[0];
    	$imgHeight = $imgInfo[1];
    	$ogpImgAreaWidth = 600;
    	$ogpImgAreaHeight = 630;
    	// マージンを算出
    	$widthMargin = ($ogpImgAreaWidth/2) - ($imgWidth/2);
    	$heightMargin = ($ogpImgAreaHeight/2) - ($imgHeight/2);
    	// 合成
    	imagecopy($baseImg, $odaiImg, $widthMargin, $heightMargin, 0, 0, $imgWidth, $imgHeight);
    	return $baseImg;
	}

	private function generateOdaiOgp($odaiId){
    	// お題タイプ確認
		$odaiT = TableRegistry::get('Odai');
		$odaiData = $odaiT->getData(['id' => $odaiId]);
		// ないからリダイレクト
		if (empty($odaiData)) {
	        return $this->redirect(['action' => 'input', 'i' => $odaiId]);
		}
    	$type = $odaiData["type"];
    	$baseImg = "";
    	// テキスト回答の場合
    	if ($type == ODAI_TYPE_TEXT) {
			// まずは質問テキスト入れる
			// 改行があるか確認
	    	$baseImg = imagecreatefrompng(WWW_ROOT.'img/ogp_odai_text.png');
			if (!empty(strstr($odaiData["text"], PHP_EOL))) {
				$baseImg = $this->eolSizeAdjust($baseImg, $odaiData["text"]);
			}else{
				$baseImg = $this->sizeAdjust($baseImg, $odaiData["text"]);
			}
    	}else{
		// 画像回答の場合
	    	$baseImg = imagecreatefrompng(WWW_ROOT.'img/ogp_odai_img.png');
			$baseImg = $this->imgAdjust($baseImg, $odaiData["img_url"]);
    	}

		// 出力
		$path = '/img/odai_ogp/'.date('YmdHis')."_".substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 20).".png";
		$imgSavePath = WWW_ROOT.$path;
    	imagepng($baseImg, $imgSavePath);

		return $odaiT->updateData($odaiId, ["ogp_img_url" => $path]);
    }
    

}
