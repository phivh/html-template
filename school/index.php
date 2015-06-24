<?php
//email list
$aMailto = array("vietnam3@alive-web.co.jp");
$from = "vietnam3@alive-web.co.jp";
$fromname = "Alive株式会社テストメール";
// 設定
require("./jphpmailer.php");
$script = "";
$gtime = time();

// グローバル変数とサニタイジング
$action = htmlspecialchars($_POST['action']);

//お問い合わせフォーム内容
$reg_name = htmlspecialchars($_POST['name']);
$reg_furi = htmlspecialchars($_POST['furi']);
$reg_email = htmlspecialchars($_POST['email']);
$reg_tel = htmlspecialchars($_POST['tel']);
$reg_code = htmlspecialchars($_POST['code']);
$reg_address = htmlspecialchars($_POST['add']);
$reg_content = htmlspecialchars($_POST['content']);
$reg_url = htmlspecialchars($_POST['url']);
$reg_sl01 = htmlspecialchars($_POST['sl01']);
$reg_sl02 = htmlspecialchars($_POST['sl02']);
$reg_sl03 = htmlspecialchars($_POST['sl03']);
$reg_sl04 = htmlspecialchars($_POST['sl04']);
$reg_sl05 = htmlspecialchars($_POST['sl05']);
$reg_sl06 = htmlspecialchars($_POST['sl06']);
$reg_firstchoise = $reg_sl01.$reg_sl02.$reg_sl03;
$reg_secondchoise = $reg_sl04.$reg_sl05.$reg_sl06;
// 処理分岐
if($action == "confirm"){
//======================================================================================== お問い合わせ確認画面
html_header();
$br_reg_content = nl2br($reg_content);
?>
<div id="mainContent">
<section class="form">
	<form method="post" class="form-1" action="<?php echo $script ?>?<?php echo $gtime ?>" >
		<!-- Anti spam part1: the contact form -->
		<p class="hid_url">Leave this empty: <input type="text" name="url" value="<?php echo $reg_url ?>"/></p>
		<div class="innerPad02">
		<dl>
			<dt>お名前</dt>
			<dd>
				<?php echo $reg_name;?>
			</dd>
			<dt>フリガナ</dt>
			<dd>
				<?php echo $reg_furi;?>
			</dd>
			<dt>希望日時</dt>
			<dd>
				<div>
					<h4>第一希望</h4>
					<ul>
						<li>
							<?php if($reg_sl01){ echo $reg_sl01;?>
							<span>月</span>
							<?php } if($reg_sl02){ echo $reg_sl02;?>
							<span>日</span>
							<?php }if($reg_sl03){ echo $reg_sl03;?>
							<span>時頃</span><?php }?>
						</li>
					</ul>
					<h4>第二希望</h4>
					<ul>
						<li>
							<?php if($reg_sl04){ echo $reg_sl04;?>
							<span>月</span>
							<?php } if($reg_sl05){ echo $reg_sl05;?>
							<span>日</span>
							<?php }if($reg_sl06){ echo $reg_sl06;?>
							<span>時頃</span><?php }?>
						</li>
					</ul>
				</div>
			</dd>
			<dt>メールアドレス</dt>
			<dd>
				<?php echo $reg_email;?>
			</dd>
			<dt>お電話番号</dt>
			<dd>
				<?php echo $reg_tel?>
			</dd>
			<dt>郵便番号</dt>
			<dd>
				〒&nbsp;<?php echo $reg_code;?>
			</dd>
			<dt>ご住所</dt>
			<dd>
				<?php echo $reg_address;?>
			</dd>
			<dt>備考</dt>
			<dd>
				<?php echo $reg_content;?>
			</dd>
		</dl>
		<input type="hidden" name="name" value="<?php echo $reg_name ?>" />
		<input type="hidden" name="furi" value="<?php echo $reg_furi ?>" />
		<input type="hidden" name="email" value="<?php echo $reg_email ?>" />
		<input type="hidden" name="tel" value="<?php echo $reg_tel ?>" />
		<input type="hidden" name="code" value="<?php echo $reg_code ?>" />
		<input type="hidden" name="add" value="<?php echo $reg_address ?>" />
		<input type="hidden" name="content" value="<?php echo $reg_content ?>" />
		<input type="hidden" name="url" value="<?php echo $reg_url ?>" />
		<input type="hidden" name="sl01" value="<?php if($reg_sl01){ echo $reg_sl01.'月';}?>" />
		<input type="hidden" name="sl02" value="<?php if($reg_sl02){ echo $reg_sl02.'日'; } ?>" />
		<input type="hidden" name="sl03" value="<?php if($reg_sl03){ echo $reg_sl03.'時頃' ;} ?>" />
		<input type="hidden" name="sl04" value="<?php if($reg_sl04){ echo $reg_sl04.'月' ;} ?>" />
		<input type="hidden" name="sl05" value="<?php if($reg_sl05){ echo $reg_sl05.'日' ;} ?>" />
		<input type="hidden" name="sl06" value="<?php if($reg_sl06){ echo $reg_sl06.'時頃' ;} ?>" />
		<p class="taC t20b20">
			<a href="javascript:history.back()">
				入力内容を修正する
			</a>
		</p>
		<div class="taC">
			<input type="image" src="img/top/btn_sent.png" width="248" class="t0b30" />
			<input type="hidden" name="action" value="send" />
		</div>
	</div>
	</form>
</section>
</div>
<?php

	html_footer();

}elseif($action == "send"){
//========================================================================================== お問い合わせ確認画面



	$entry_time = gmdate("Y/m/d H:i:s",time()+9*3600);
	$entry_host = gethostbyaddr(getenv("REMOTE_ADDR"));
	$entry_ua = getenv("HTTP_USER_AGENT");



$msgBody = "
■お名前
$reg_name

■フリガナ
$reg_furi

■希望日時
第一希望
$reg_firstchoise

第二希望
$reg_secondchoise

■メールアドレス
$reg_email
";
if(isset($reg_tel) && $reg_tel != '')
{
$msgBody .= "
■お電話番号
$reg_tel
";
}
if(isset($reg_code) && $reg_code != '')
{
$msgBody .= "
■郵便番号
$reg_code
";
}
if(isset($reg_address) && $reg_address != '')
{
$msgBody .= "
■ご住所
$reg_addres
";
}
if(isset($reg_content) && $reg_content != '')
{
$msgBody .= "
■備考
$reg_content
";
}


//お問い合わせメッセージ送信
	$subject = "ホームページからお問い合わせがありました";
	$body = "

登録日時：$entry_time
ホスト名：$entry_host
ブラウザ：$entry_ua


ホームページからお問い合わせがありました。


$msgBody


";

//お客様用メッセージ
	$subject1 = "お問い合わせありがとうございました";
	$body1 = "

$reg_name 様

この度はお問い合わせいただきまして誠にありがとうございます。
こちらは自動返信メールとなっております。
弊社にて確認した後、改めてご連絡させていただきます。

以下、お問い合わせ内容となっております。
ご確認くださいませ。
---------------------------------------------------------------
---------------------------------------------------------------

$msgBody


---------------------------------------------------------------
About company
---------------------------------------------------------------

";
	// メール送信
	mb_language("ja");
	mb_internal_encoding("UTF-8");
	
	
	//お客様受け取りメール送信
	$email1 = new JPHPmailer();
	$email1->addTo($reg_email);
	$email1->setFrom($from,$fromname);
	$email1->setSubject($subject1);
	$email1->setBody($body1);
	//Anti spam advanced version 2 start: Don't send blank emails
	if( $reg_name <> "" && $reg_email <> "" ) {
		
		//Anti spam advanced version 1 start: The preg_match() is there to make sure spammers can’t abuse your server by injecting extra fields (such as CC and BCC) into the header.
		if( $reg_email && !preg_match( "/[\r\n]/", $reg_email) ) {
			
			//Anti spam part1: the contact form start
			if($reg_url == ""){
		     	// then send the form to your email
				if($email1->Send()) {};
			} // otherwise, let the spammer think that they got their message through
			//Anti spam part1: the contact form end
		}//Anti spam advanced version 1 end
	}//Anti spam advanced version 2 end: Don't send blank emails
	
	//メール送信
	$email = new JPHPmailer();
	for($i = 0; $i < count($aMailto); $i++)
	{
		$email->addTo($aMailto[$i]);
	}
	$email->setFrom($reg_email, $reg_name."様");
	$email->setSubject($subject);
	$email->setBody($body);
	//Anti spam advanced version 2 start: Don't send blank emails
	if( $reg_name <> "" && $reg_email <> "" ) {
		//Anti spam part1: the contact form start
		if($reg_url == ""){
	     	// then send the form to your email
			if($email->Send()) {};
		} // otherwise, let the spammer think that they got their message through
		//Anti spam part1: the contact form end
	}//Anti spam advanced version 2 end: Don't send blank emails
	header("Location: indexThx.php");
	exit;

}else{
//================================================================================================== 初期画面
	html_init("");
}

////////////////////////////////////////////////////////////////////////////// HTML初期画面
function html_init(){

	global $gtime, $script;
	html_header();
?>
<div id="mainContent">
			<img src="img/top/bg_top01.jpg" class="img100" alt="無料体験会">
			<p class="innerPad fz13 color01 txt_top01">世界の第一線で活躍するマッサージ師「川梅義和」が、これからボディケアを学んでいきたい方、スキルアップ、キャリアアップを考えている方に“川梅式”の施術法や学び方、働き方をお教えします。</p>
			<p><img src="img/top/img_top02.png" class="img100 img_top01"></p>
			<a href="#form"><img src="img/top/btn_contact01.png" class="img100 mb40" alt="WEBからのお申し込みはこちら"></a>
			
			<section>
				<h2 class="mb20"><img src="img/top/img_themes01.png" class="img100" alt="一人でも多くの施術者が
お客様に喜んでもらえるように"></h2>
				<p class="mb20"><img src="img/top/pic_kawaume01.jpg" class="img100" alt="川梅 義和"></p>
				<p class="innerPad t0b10">プラムツリーは創業より<span class="color02 fwB">12年間増収増益</span>を続けている県内に3店舗を構えるマッサージ店です。</p>

				<p class="innerPad t0b30">私は<span class="color02 fwB">中日ドラゴンズのトレーナー</span>になりたいという思いから鍼灸マッサージの免許を取得し、マッサージ店の経営と並行して中日ドラゴンズの臨時トレーナーや
<span class="color02 fwB">フィギュアスケートの安藤美姫選手の専属トレーナー</span>として日本を飛び出して世界の第一線で活動をしてたくさんの経験をしてきました。</p>
				<p class="innerPad t0b30">そして<span class="color02 fwB">「この経験を通じて得たものをたくさんの人に伝えていきたい」<br>
「施術者同志が情報を共有できるコミュニティを作りたい」</span>という思いからこのスクールを始めました。</p>

				<p class="innerPad t0b30">今までもマッサージスクール、マッサージセミナー、ワンデイレッスンなど述べ人数で言ったら
<span class="color02 fwB">何百人と教えてきた実績がある</span>ので、これからも一人でも多くの施術者が<span class="color02 fwB">「お客様に喜んで頂ける施術者」</span>
として活躍する施術者のサポートをしていきたいと思います。</p>

				<p class="innerPad t0b40">この体験会では明日からの施術に役立つテクニックをお教えします。<br>
先着6名ですので、是非一度お越しください。</p>
			</section>

			<section>
				<h2 class="mb20"><img src="img/top/img_themes02.png" class="img100" alt="この体験会の3つのメリット！"></h2>

				<div class="pointBlock01">
					<div class="inner">
						<p class="t0b5"><img src="img/top/img_point01.png" class="img100" alt="施術力を上げるノウハウを伝授！"></p>
						<p class="fz13 mb20">体が大きい人は大きい人なりの揉み方、小さい人は小さい人なりの効かせ方があります。<br>それぞれの体型に合った施術法を的確にアドバイス・改善していきます。また個々に悩んでいる施術への壁をすべて解消します。</p>
						<p><img src="img/top/pic_point01.jpg" class="img100" alt="施術力を上げるノウハウを伝授！"></p>
					</div>
				</div>
				<div class="pointBlock01">
					<div class="inner">
						<p class="t0b5"><img src="img/top/img_point02.png" class="img100" alt="指名を取れる施術者になるテクニックを伝授！"></p>
						<p class="fz13 mb20">本物になるなら本物に学ぶのが一番です。「あの人が指名を取れるのはなぜ？」<br>
あなたは決して下手ではありません。ただ方法を知らないだけなんです！<br>施術歴は関係ありません。<br>
技術はもちろん人間性も見られているんです。</p>
						<p><img src="img/top/pic_point02.jpg" class="img100" alt="指名を取れる施術者になるテクニックを伝授！"></p>
					</div>
				</div>
				<div class="pointBlock02">
					<div class="inner">
						<p class="t0b5"><img src="img/top/img_point03.png" class="img100" alt="個々に合わせた適切な学び方を伝授"></p>
						<p class="fz13 mb20">様々な症状のお客様から、トップアスリートまで幅広く経験してきた第一線で活躍するトレーナーだからこそわかる手法をお教えします。<br>
ただ揉みほぐすだけではなく、なで・こすり・押し・伸ばし・叩くなど万人に合う施術からスポーツ選手までを施術できる技術を教えます。</p>
						<p><img src="img/top/pic_point03.jpg" class="img100" alt="個々に合わせた適切な学び方を伝授"></p>
					</div>
				</div>
			</section>

			<section>
				<h2 class="mb20"><img src="img/top/img_themes03.png" class="img100" alt="こんな悩みがある方は是非ご参加ください"></h2>
				<img src="img/top/img_specific01.png" alt="こんな悩みがある方は是非ご参加ください" class="img100 mb20">
				<a href="tel:052-654-0032"><img src="img/top/btn_tel01.png" alt="こんな悩みがある方は是非ご参加ください" class="img100 mb20"></a>
				<a href="#form"><img src="img/top/btn_contact01.png" class="img100 mb30" alt="WEBからのお申し込みはこちら"></a>
				<p class="innerPad02 mb20"><img src="img/top/pic_specification01.png" class="img100" alt="個々に合った内容をオーダーメイドしてカリキュラムを作成"></p>
				<p class="innerPad02 mb20">「ヨガのスキルを上げるために解剖学を強めたい」、<br>「お客様がリピートしてくれるようなマッサージ施術がしたい」など人によって身につけたいスキルや悩みは十人十色です。<br>プラムツリーではしっかりとヒアリングを行い、個々にあったカリキュラムを組んでいきます。<br>ここでは講座内容の一部をご紹介します。</p>

				<h3><img src="img/top/h3_themes01.png" class="img100" alt="講座内容案内"></h3>
				<div class="innerPad02">
					<ul class="ul_classes01 mb30">
						<li>お客様を逃さない手技・施術の組み立て方</li>
						<li>「効かせる」施術法</li>
						<li>コミュニケーション術（会話のコツ）</li>
						<li>矯正法・ストレッチ法</li>
						<li>肉体的疲労へのアプローチ</li>
						<li>精神的疲労へのアプローチ</li>
						<li>施術に費やすべき箇所</li>
						<li>マンネリからの脱却！変化に富んだ施術法</li>
						<li>強く押すためのテクニック</li>
						<li>解剖学について</li>
						<li>学び方、働き方について</li>
						<li>施術者としての在り方</li>
					</ul>
				</div>
			</section>

			<section class="section_spec01">
				<h2 class="mb20"><img src="img/top/img_themes04.png" class="img100" alt="無料体験会概要"></h2>
				<div class="innerPad02">
					<h3><img src="img/top/h3_outline01.png" width="120" height="19" alt="当日の内容"></h3>
					<ul class="ul_outline01 mb40">
						<li>1.川梅式スクールの内容説明</li>
						<li>2.技術体験 明日から使える施術テクニック編</li>
						<li>3.質問タイム</li>
					</ul>
					<h3 class="mb10"><img src="img/top/h3_outline02.png" width="64" height="19" alt="場所"></h3>
					<p class="mb20"><img src="img/top/pic_map01.jpg" class="img100" alt="当日の内容"></p>
					<h4 class="fz15 fwB color03">プラムツリー本店</h4>
					<p class="mb20">〒455-0066 愛知県名古屋市港区寛政町２丁目３０あおなみ線 荒子川公園駅より徒歩5分</p>
					<p class="border01"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d26112.12555167453!2d136.863442!3d35.106319!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60037833489d8307%3A0x22b98a1834498cb7!2z44CSNDU1LTAwNjYg5oSb55-l55yM5ZCN5Y-k5bGL5biC5riv5Yy65a-b5pS_55S677yS5LiB55uu77yT77yQ!5e0!3m2!1sja!2sjp!4v1435004484111" width="100%" height="275" frameborder="0" style="border:0" allowfullscreen></iframe></p>

					<h3 class="mb20"><img src="img/top/h3_outline03.png" width="64" height="19" alt="講師"></h3>
					<p class="mb20"><img src="img/top/pic_kawaume02.jpg" class="img100" alt="川梅 義和"></p>
					<p class="mb30">はりきゅうマッサージ『プラムツリー』代表<br>鍼灸師　マッサージ師<br>2008年～現在<br>フィギュアスケート安藤美姫 専属トレーナー　</p>

				</div>
				<h3 class="mb20"><img src="img/top/h3_themes02.png" class="img100" alt="講座内容案内"></h3>
				<div class="innerPad02">
					<ul class="ul_outline02">
						<li>
							<p class="color04">2006～2007年</p>
							<p>中日ドラゴンズ　臨時トレーナー</p>
						</li>
						<li>
							<p class="color04">2011年</p>
							<p>フィギュアスケート世界選手権<br>ロシアワールドカップ１位選手　中国、台湾に帯同</p>
						</li>
						<li>
							<p class="color04">2010年</p>
							<p>フィギュアスケート世界選手権<br>イタリア、フランス、ロシアワールドカップ出場選手に帯同</p>
						</li>
						<li>
							<p class="color04">2010年</p>
							<p>バンクーバーオリンピック大会　帯同</p>
						</li>
						<li>
							<p class="color04">2009年</p>
							<p>フィギュアスケート世界選手権<br>ロサンゼルスワールドカップに帯同</p>
						</li>
					</ul>
				</div>
				
			</section>

			<section class="section_spec01 p0b20">
				<h2 class="mb20"><img src="img/top/img_themes05.png" class="img100" alt="参加者の声"></h2>
				<div class="innerPad02">
					<div class="voiceBlock01">
					<p class="fwB mb10 color03">T.Eさま（30代 男性）</p>
					<p class="txt_voice01">指導だけじゃなく、<span class="color02">アフターケア</span>もしてくれて良い職場に出会えました。</p>
					手技の教え方も分かりやすく良かったのですが、余談や体験談にも魅了されました。わたしは転職希望だったので、その相談や仕事の紹介などもしてもらえて、おかげでとても良い職場で、安定したお客様を獲得出来ています。<br>アフターケア付きの素晴らしいセミナーです！
					</div>
					<div class="voiceBlock01">
					<p class="fwB mb10 color03">N.Aさま（30代 女性）</p>
					<p class="txt_voice01">先生の<span class="color02">経験談を含めた実例</span>を聞くことができ、とても参考になりました。</p>
					ドラゴンズや安藤美姫さんのトレーナーさんということで、そういった体験談も交えて教えてもらえてとても楽しく、また実感を通して学べ参考になりました。施術だけではなく、お客さんとのコミュニケーション術なども教えてもらえて、この仕事の面白さを改めて実感できたセミナーでした。
					</div>
					<div class="voiceBlock01">
					<p class="fwB mb10 color03">O.Sさま（30代 男性）</p>
					<p class="txt_voice01">お客様に<span class="color02">「楽になった」</span>と言ってもらえるようになったのが何よりの喜び！</p>
					今まではお客さんの反応がわからず、本当に効いているのか不安でした。セミナーを受けてから、施術中の会話でお客様の身体にしっかり対応できるようになり、お客さんから「楽になったよ！」という声をかけてもらえるようになりました。それが何よりも原動力になっています。
					</div>
				</div>
				
			</section>
			
			<section class="section_padding01">
				<div class="innerPad02">
					<img src="img/top/img_trial01.png" class="img100" alt="参加者の声">
					<img src="img/top/img_cv01.png" class="img100 txt_top02 mb10" alt="お申し込みはこちらから">
					<a href="tel:052-654-0032"><img src="img/top/btn_tel01.png" alt="こんな悩みがある方は是非ご参加ください" class="img100 mb30"></a>

					<h3 class="mb10"><img src="img/top/h3_contact01.png" class="img100" alt="お申し込みはこちらから"></h3>
					<p>下記の情報に御記入の上、【確認画面】ボタンをクリックしてください。
折り返し弊社より御連絡させていただきます。
(<span class="color02">※</span>は入力必須項目です)</p>
				</div>
			</section>
			<section class="form">
			<form method="post" class="form-1" action="<?php echo $script ?>?<?php echo $gtime ?>" name="form1" onSubmit="return check()">
				<p class="hid_url">Leave this empty: <input type="text" name="url" /></p><!-- Anti spam part1: the contact form -->
				<div class="innerPad02">
					<dl>
						<dt>お名前<span>※</span></dt>
						<dd>
							<p class="test"><input type="text" id="name" name="name" value="<?php echo $reg_name;?>" placeholder="例)山田太郎"></p>
						</dd>
						<dt>フリガナ<span>※</span></dt>
						<dd>
							<p class="test"><input type="text" id="furi" name="furi" value="<?php echo $reg_furi;?>" placeholder="例) ヤマダタロウ"></p>
						</dd>
						<dt>希望日時<span>※</span></dt>
						<dd>
							<div class="slGroup">
								<h4>第一希望</h4>
								<ul class="chkrequiredgroup" id="checkgroup01">
									<li>
										<div class="w-sl">
											<select name="sl01" id="sl01">
												<option value="">--</option>
												<?php
													for($m=1;$m<=12;$m++){
														if($reg_sl01==$m) define($selected,'selected="selected"');
														echo '<option '.$selected.' value="'.$m.'">'.$m.'</option>';
													}
												?>
											</select>
										</div>
										<span>月</span>
									</li>
									<li>
										<div class="w-sl">
											<select name="sl02" id="sl02">
												<option value="">--</option>
												<?php
													for($d=1;$d<=31;$d++){
														if($reg_sl02==$d) define($selected,'selected="selected"');
														echo '<option '.$selected.' value="'.$d.'">'.$d.'</option>';
													}
												?>
											</select>
										</div>
										<span>日</span>
									</li>
									<li>
										<div class="w-sl">
											<select name="sl03" id="sl03">
												<option value="">--</option>
												<?php
													for($h=1;$h<=24;$h++){
														if($reg_sl03==$h) define($selected,'selected="selected"');
														echo '<option '.$selected.' value="'.$h.'">'.$h.'</option>';
													}
												?>
											</select>
										</div>
										<span>時頃</span>
									</li>
								</ul>
								<h4>第二希望</h4>
								<ul class="chkrequiredgroup" id="checkgroup02">
									<li>
										<div class="w-sl">
											<select name="sl04" id="sl04">
												<option value="">--</option>
												<?php
													for($m=1;$m<=12;$m++){
														if($reg_sl01==$m) define($selected,'selected="selected"');
														echo '<option '.$selected.' value="'.$m.'">'.$m.'</option>';
													}
												?>
											</select>
										</div>
										<span>月</span>
									</li>
									<li>
										<div class="w-sl">
											<select name="sl05" id="sl05">
												<option value="">--</option>
												<?php
													for($d=1;$d<=31;$d++){
														if($reg_sl02==$d) define($selected,'selected="selected"');
														echo '<option '.$selected.' value="'.$d.'">'.$d.'</option>';
													}
												?>
											</select>
										</div>
										<span>日</span>
									</li>
									<li>
										<div class="w-sl">
											<select name="sl06" id="sl06">
												<option value="">--</option>
												<?php
													for($h=1;$h<=24;$h++){
														if($reg_sl03==$h) define($selected,'selected="selected"');
														echo '<option '.$selected.' value="'.$h.'">'.$h.'</option>';
													}
												?>
											</select>
										</div>
										<span>時頃</span>
									</li>
								</ul>
							</div>
						</dd>
						<dt>メールアドレス<span>※</span></dt>
						<dd>
							<p class="test"><input type="text" name="email" id="email" value="<?php echo $reg_email;?>" placeholder="例) yamada@plumtree.co.jp"></p>
						</dd>
						<dt>お電話番号 ※半角英数</dt>
						<dd>
							<p class="test"><input type="text" name="tel" placeholder="例)090-1111-1111" value="<?php echo $reg_tel;?>"></p>
						</dd>
						<dt>郵便番号 ※半角英数</dt>
						<dd class="w-code">
							<p class="test"><span style="color:#4D4D4D">〒</span>&nbsp;<input type="text" name="code" value="<?php echo $reg_code;?>" onKeyUp="AjaxZip3.zip2addr(this,'','add','add')" placeholder="例) 446-0071"></p>
						</dd>
						<dt>ご住所</dt>
						<dd>
							<input type="text" name="add" id="add" value="<?php echo $reg_address;?>" placeholder="例) 愛知県名古屋市港区寛政町２丁目３０">
						</dd>
						<dt>備考</dt>
						<dd>
							<textarea name="content" id="content" cols="30" rows="10" value="<?php echo $reg_content;?>"></textarea>
						</dd>
					</dl>
					<p class="t10b20">【個人情報の取扱いについて】<br>・本フォームからお客様が記入・登録された個人情報は、資料送付・電子メール送信・電話連絡<br>　などの目的で利用・保管し、第三者に開示・提供することはありません。</p>
					 <div class="taC">
						<p class="t0b20">
							<label><input type="checkbox" name="check1" value="ok"><span style="font-size:14px;"><b> 個人情報の取扱いに同意する</b></span></label>
						</p>
						<input type="image" src="img/top/btn_cf.png" width="248" class="t0b30" />
						<input type="hidden" name="action" value="confirm" />
					</div>
					<p class="taC">上記フォームで送信できない場合は、必要項目をご記入の上、<a id="mailContact" href="#"></a>までメールをお送りください。</p>
				</div>
			</form>
			</section>
		</div>

<?php
html_footer();
}
////////////////////////////////////////////////////////////////////////////// HTMLヘッダー
function html_header(){
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0">
<meta name="format-detection" content="telephone=no">
<title>施術の技術と接客スキルが学べる整体・鍼灸・ボディケアスクール プラムツリー</title>
<meta name="description" content="12年連続増収増益の繁盛店オーナーが指導する施術の技術と接客スキルが学べる整体・鍼灸・ボディケアスクール" />
<meta name="keywords" content="整体,鍼灸,ボディケア,スクール,名古屋" />
<!-- CSS ==================================================-->
<link rel="stylesheet" href="common/css/base.css" media="all">
<link rel="stylesheet" href="common/css/style.css" media="all">
<link rel="stylesheet" href="common/css/form.css" media="all">
<link rel="stylesheet" href="common/css/exvalidation.css" media="all">
<!-- Favicons ==================================================-->
<link rel="icon" href="common/img/icon/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="index contents" href="/" title="ホーム">
<!-- Anti spam part1: the contact form start -->
<style>
	.hid_url { display:none;}
</style>
<!-- Anti spam part1: the contact form end -->
<!-- Google Analytics start -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-45924622-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- Google Analytics end -->

</head>

<body id="top">
	<header id="header">
		<h1 class="head">港区の整体・マッサージ・鍼灸ならプラムツリー</h1>
		<div id="headerInner" class="clearfix">
			<a href=""><img src="img/top/logo_header01.png" width="117" height="40" class="logo"></a>
			<a href="tel:052-654-0032"><img src="img/top/btn_header01.png" width="174" height="48" class="headContact"></a>
			<!-- /hBlock -->
		</div>
		<!-- /headerInner -->
	</header>
	<!-- /header -->
	<div id="container" class="clearfix">
		<?php 
		}
		////////////////////////////////////////////////////////////////////////////// HTMLフッター
		function html_footer(){
		?>
		<!-- /mainContent -->
	</div>
	<!-- /container -->
	
	<footer id="footer">		
		<p id="copyright">Copyright&copy;  plum tree  All Rights Reserved</p>
	</footer>
	<!-- /footer end -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="common/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="common/js/smoothscroll.js"></script>
	<script type="text/javascript" src="common/js/common.js"></script>
	<script type="text/javascript" src="common/js/script.js"></script>
	<script type="text/javascript" src="common/js/form/ajaxzip3.js" charset="UTF-8"></script>
	<script type="text/javascript" src="common/js/form/jquery.cookie.js"></script>
	<script type="text/javascript" src="common/js/form/exvalidation.js"></script>
	<script type="text/javascript" src="common/js/form/exchecker-ja.js"></script>
	<script type="text/javascript">
		$(function(){
		  $("form").exValidation({
			rules: {
				name: "chkrequired",
				furi: "chkrequired",
				email: "chkrequired chkemail"
			},
			stepValidation: true,
			scrollToErr: true,
			errHoverHide: true
		  });
		});
	</script>
	<script type="text/javascript">
		<!--
		function check(){
			var flag = 0;
			if(!document.form1.check1.checked){
				flag = 1;
			}
			if(flag){
				window.alert('「個人情報の取扱いに同意する」にチェックを入れて下さい');
				return false;
			}
			else{
				return true;
			}
		}
		// -->
</script>
	<script type="text/javascript" src="common/js/form/jquery.gafunc.js"></script>
	<!-- Anti spam part2: clickable email address start -->
	<script type="text/javascript">
		$(function(){
			var address = "xxx" + "@" + "sample.co.jp";
			$("#mailContact").attr("href", "mailto:" + address);
			$("#mailContact").text(address);
		});
	</script>
	<!-- Anti spam part2: clickable email address end -->
<!-- End Document
================================================== -->
</body>
</html>
<?php
	exit;
}
?>