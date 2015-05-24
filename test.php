
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php

//取得元指定
$rssOrg = simplexml_load_file("http://tech.uzabase.com/rss");
//カット文字列
$CutWord = "NewsPicks";

//実行部
$disp = new News();
$disp->url = $rssOrg;
$disp->cut = $CutWord;
$disp->setNews();


//ニュース取得用クラス
class News{

	public $url;
	public $cut;

//ニュースを取得する
	public function setNews(){
		foreach ($this->url->channel->item as $item) {
    		$date = $item->pubDate;
    		$link = $item->link;
    		$title = self::ReplaceText($item->title, $this->cut);
    		Disp::DispDate($date);
    		Disp::DispTitle($link, $title);
		}
	}

	//カット対象文字列が含まれている場合、カットして返す
	public function ReplaceText($text, $cut) {
		if (strstr($text, $cut)){
				$text= str_replace($cut, "", $text);
		}
		return $text;
	}

}


//ニュース表示用クラス
class Disp{

	//日付表示
	public function DispDate($date) {
		$date = date('Y.m.d', strtotime($date));
		echo '<dt>' . $date . '</dt>';
	}

	//リンク、タイトル表示
	public function DispTitle($link, $title) {
		echo '<dd><a href="' . $link . '" target="_blank">' . $title . '</a></dd>';
	}
	
}
