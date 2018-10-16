
@extends('layouts.app')
@section('content')
<div class="container bootstrap snippet pt-150px">

<div class="row">
<div class="col-8 offset-2">
  <div class="">
    <h3>
      Creator Worksは、LINEのスタンプ、着せ替えを作りたい人とクリエイターを結ぶマッチングサービスです。
    </h3>
  </div>
</div><!--/col-3-->
<div class="col-12 text-center mt-5">
  <h1>ご利用方法</h1>
</div>
<div class="row">
  <div class="col-12">
    <div class="cards">
      <div class="card-header  border-top border-2 border-dark mt-5">
        <h3>作品投稿</h3>
      </div>
      <div class="card-body">
        <div class="">
          <p>
            クリエイター様は、自分の作品を投稿することで、自分のスキルをユーザー様に見せることができます。 
作品を見て、「この人に作ってもらいたい！」と思ったユーザー様は、その人にメッセージを送ることができ、自分のアイデアを元に、一緒に作品を作っていくことができます。
          </p>
          <div class="row">
            <div class="col-5 offset-1 text-center">
              <img src="img/guide/user.png" width="160" height="220">
              <h4 class="bg-primary text-light py-2">
                作品を作ってもらいたいユーザー様
              </h4>
            </div>
            <div class="col-5 text-center">
              <img src="img/guide/creator.png" width="160" height="220">
              <p class="bg-success text-light py-2">
                作品が作れるクリエイター様
              </p>
            </div>
            
          </div>
          <div class="row">
            <div class="col-10 offset-1">
              <table>
                <tbody>
                  <tr class="border-top border-dark ">
                    <td class="w-50 border-right border-dark">
                      
                    </td>
                    <td class="w-50 px-3 py-3">
                      <p class="border border-1 border-dark rounded m-0 p-3 ">
                        <span class="span-header">１.作品投稿</span><br>作品を投稿して、自分のスキルをユーザー様にアピールします。
                      </p>
                    </td>
                  </tr>
                   <tr>
                    
                    <td class="w-50 border-right border-dark px-3 py-3">
                      <p class="border border-1 border-dark rounded m-0 p-3">
                        <span class="span-header">２.メッセージ送信</span><br>いいなと思ったクリエイター様を見つけたら、まずメッセージを送信します。
                      </p>
                    </td>
                    <td class="w-50">
                      
                    </td>
                  </tr>
                   <tr>
                    <td class="w-50 border-right border-dark px-3">
                      
                    </td>
                    <td class="w-50 px-3 py-3">
                      <p class="border border-1 border-dark rounded  m-0 p-3">
                        <span class="span-header">３.決済の同意</span><br>ユーザー様が作りたいアイデアをヒアリングし、できると思ったら「決済」の同意をします。
                      </p>
                    </td>
                  </tr>
                   <tr>
                   
                    <td class="w-50 border-right border-dark px-3 py-3">
                      <p class="border border-1 border-dark rounded m-0 p-3">
                        <span class="span-header">４.決済</span><br>ユーザー様はサービスの料金の前払いを決済して、取引に進みます。
                      </p>
                    </td>
                     <td class="w-50">
                      
                    </td>
                  </tr>
                  <tr>
                    <td class="w-50 border-right border-dark">
                      
                    </td>
                    <td class="w-50 px-3">
                      <p class="border border-1 border-dark rounded m-0 p-3 py-3">
                        <span class="span-header">５.作品作成</span><br>コミュニケーションをとり、実際に作品を一緒に作っていきます。
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center pt-3 mt-2" colspan="2">
                      <p class="border border-1 border-dark rounded w-50 m-auto m-1 p-3 py-3">
                        <span class="span-header">６.作品納品・報酬受け取り</span><br>作品納品後、お互いが同意して一連の取引が完了となります。その後クリエイター様は報酬を受け取れます。
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>

<div class="row border-top border-4 border-dark">
  <div class="col-12">
    <div class="cards">
      <div class="card-header border-top border-2 border-dark mt-5">
        <h3>作りたい作品の投稿</h3>
      </div>
      <div class="card-body">
        <div class="">
          <p>
            作りたい作品のアイデアがあるのに、スキルがなくて作れないユーザー様は、作りたい作品のアイデアを投稿することができます。逆にその作りたい作品を作れるスキルのある人は、それを見てメッセージが送れます。
          </p>
          <div class="row">
            <div class="col-5 offset-1 text-center">
              <img src="img/guide/user.png" width="160" height="220">
              <h4 class="bg-primary text-light py-2">
                作品を作ってもらいたいユーザー様
              </h4>
            </div>
            <div class="col-5 text-center">
              <img src="img/guide/creator.png" width="160" height="220">
              <h4 class="bg-success text-light py-2">
                作品が作れるクリエイター様
              </h4>
            </div>
            
          </div>
          <div class="row">
            <div class="col-10 offset-1">
              <table>
                <tbody>
                  <tr class="border-top border-dark ">
                    
                    <td class="w-50 px-3 py-3 border-right border-dark">
                      <p class="border border-1 border-dark rounded m-0 p-3">
                        <span class="span-header">１.作りたい作品の投稿</span><br>作りたい作品のアイデアを形にするために、その詳細を投稿します。
                      </p>
                    </td>
                    <td class="w-50">
                      
                    </td>
                  </tr>
                   <tr>
                    <td class="w-50 border-right border-dark">
                      
                    </td>
                    <td class="w-50 px-3 py-3">
                      <p class="border border-1 border-dark rounded m-0 p-3">
                        <span class="span-header">２.メッセージ送信</span><br>できそうだなと思ったユーザー様の投稿を見つけたら、まずメッセージを送信します。
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td class="w-50 px-3 border-right border-dark py-3">
                      <p class="border border-1 border-dark rounded  m-0 p-3">
                        <span class="span-header">３.決済の同意</span><br>クリエイター様に作りたいアイデアをヒアリングしてもらい、できると判断してもらったら「決済」の同意を得ます。
                      </p>
                    </td>
                     <td class="w-50 px-3">
                      
                    </td>
                  </tr>
                   <tr>
                   
                    <td class="w-50 border-right border-dark px-3 py-3">
                      <p class="border border-1 border-dark rounded m-0 p-3">
                        <span class="span-header">４.決済</span><br>サービスの料金の前払いを決済して、取引に進みます。
                      </p>
                    </td>
                     <td class="w-50">
                      
                    </td>
                  </tr>
                  <tr>
                    <td class="w-50 border-right border-dark">
                      
                    </td>
                    <td class="w-50 px-3 py-3">
                      <p class="border border-1 border-dark rounded m-0 p-3">
                        <span class="span-header">５.作品作成</span><br>コミュニケーションをとり、実際に作品を一緒に作っていきます。
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center pt-3 mt-2" colspan="2">
                      <p class="border border-1 border-dark rounded w-50 m-auto m-1 p-3">
                        <span class="span-header">６.作品納品・報酬受け取り</span><br>作品納品後、お互いが同意して一連の取引が完了となります。その後クリエイター様は報酬を受け取れます。
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div><!--/row-->

</div>

<script type="text/javascript">

</script>
<!-- Custom scripts for this template -->
@endsection