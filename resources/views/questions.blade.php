@extends('layouts.app')

<div class="container bootstrap snippet">
  
  <div class="row">
    <div class="col-12 text-center mt-5">
      <h1>よくある質問</h1>
    </div>
    <div class="row col-12">
      <div class="col-12">
        <div id="accordion" role="tablist">
          <div class="card">
            <div class="card-header" role="tab" id="headingOne">
              <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  <h3>・Creator Worksとは？</h3>
                </a>
              </h5>
            </div>

            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">
                LINEのスタンプ、着せ替えを作りたい人とクリエイターを結ぶマッチングサービスです。クリエイター様は、自分の作品を載せることができます。作りたい人は、それを見てメッセージを送ることができます。支払いが済むと、クリエイター様が作業を開始し、一緒に理想のスタンプ、着せ替えを作っていくことができます。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="headingTwo">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <h3>・作品投稿・作りたい作品投稿とは？</h3>
                </a>
              </h5>
            </div>
            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                クリエイター様が投稿する作品投稿は、自分の作品をアピールするものです。投稿された作品を見て、ユーザー様がメッセージを送ってくれます。
ユーザー様が投稿する作りたい作品投稿は、作りたいスタンプ・着せ替えのアイデアを発信するものです。それを見て、クリエイター様がメッセージを送ってくれます。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="headingThree">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  <h3>・登録や投稿にお金はかかりますか？</h3>
                </a>
              </h5>
            </div>
            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                かかりません。お気軽に投稿してください！
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading4">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                  <h3>・法人としても登録できますか？</h3>
                </a>
              </h5>
            </div>
            <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="heading4" data-parent="#accordion">
              <div class="card-body">
                可能です。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading5">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                  <h3>・領収証 は発行できますか？</h3>
                </a>
              </h5>
            </div>
            <div id="collapse5" class="collapse" role="tabpanel" aria-labelledby="heading5" data-parent="#accordion">
              <div class="card-body">
                はい。ご希望の方は、宛名、作品の種類、納品日の3点をお問い合せフォームまでご連絡ください。PDFファイルにて送信させていただきます。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading6">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                  <h3>・投稿の内容の編集はできますか？</h3>
                </a>
              </h5>
            </div>
            <div id="collapse6" class="collapse" role="tabpanel" aria-labelledby="heading6" data-parent="#accordion">
              <div class="card-body">
                投稿の内容の編集・削除はいつでも可能です。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading7">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
                  <h3>・キャンセルはできますか？</h3>
                </a>
              </h5>
            </div>
            <div id="collapse7" class="collapse" role="tabpanel" aria-labelledby="heading7" data-parent="#accordion">
              <div class="card-body">
                決済後は、基本的にキャンセルはできません。やむを得ない事情でキャンセルする場合、お問い合せフォームまでご一報いただけますようお願い致します。
尚、返金の際は、システム利用料を差し引いての返金となります。下記の通りです。
LINEスタンプ40個＋メイン画像1個＋トークルームタブ画像1個・・・15,000円、アニメーションスタンプ24個＋メイン画像1個＋トークルームタブ画像1個・・・22,000円、着せ替え1個・・・25,000円
尚、ここからpaypal手数料も差し引かれますので何卒ご了承いただけますようお願い申し上げます。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading8">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                  <h3>・直接契約を要求された</h3>
                </a>
              </h5>
            </div>
            <div id="collapse8" class="collapse" role="tabpanel" aria-labelledby="heading8" data-parent="#accordion">
              <div class="card-body">
                Creator Worksを通さず行う契約は、トラブルの元となりますので絶対におやめ下さい。
直接契約を要求された場合、断った上でお問い合せフォームまでご連絡下さいますようお願い致します。
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" role="tab" id="heading9">
              <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                  <h3>・不具合について</h3>
                </a>
              </h5>
            </div>
            <div id="collapse9" class="collapse" role="tabpanel" aria-labelledby="heading9" data-parent="#accordion">
              <div class="card-body">
                お問い合せフォームまでご連絡ください。
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!--/row-->
  
</div>