<?php

// データまとめ用の空の変数
$str = "";
$stropinion = "";
$strmaleopinion = "";
$strfemaleopinion = "";

// ファイルを開く（読み取り専用＝r）
$file = fopen("data/opinion.csv","r");
flock($file, LOCK_EX);

// fgets()で1行ずつ取得→$lineに格納
if($file){
  while($line = fgets($file)){
$str .= "<tr><td>{$line}</td></tr>";  
  }
}

//オリジナル

$csv_file = file_get_contents("data/opinion.csv");

//変数を改行毎の配列に変換
$aryHoge = explode("\n", $csv_file);

$aryCsv = [];
foreach($aryHoge as $key => $value){
    //if($key == 0) continue; 1行目が見出しなど、取得したくない場合
    if(!$value) continue; //空白行が含まれていたら除外
    $aryCsv[] = explode(",", $value);
}

//print_r($aryCsv);





/*$stropinion = new SplFileObject("data/opinion.csv", 'r');
  while (!$stropinion->eof()) {
    $stropinion_= $stropinion->fgetcsv("\t");
    if (! empty($stropinion_[0]))
    {
      echo $stropinion_[1];
      echo '<BR>';
    }
  }*/

// ロックを解除する
flock($file, LOCK_UN);
// ファイルを閉じる
fclose($file);

// `$str`に全てのデータ（タグに入った状態）がまとまるので，HTML内の任意の場所に表示する．





?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>管理者用ページ</title>
</head>

<body>
 <header>
     <h1>うちの家に関するアンケート</h1>
     <p>管理者用ページ</p>
 </header>

 <main>

  <h2>みんなの感想</h2>
  <div id="chartdiv" class="chartdiv"></div>
  <div class="danjobetsu">
    <div class="josei">
    <h2>女性の感想</h2>
    <div id="chartdiv2" class="chartdiv"></div>
    </div>
    
    <div class="dansei">
    <h2>男性の感想</h2>
    <div id="chartdiv3" class="chartdiv"></div>
    </div>
  </div>

<h2>印象に残った場所</h2>
<div style="width:500px; height:200px; margin:auto;">
<canvas id="myChart"></canvas>
</div>
<div class="danjobetsu" style="width:400px; height:400px; margin:auto;">
  <canvas id="myChartfemale" style="position: relative" class="josei"></canvas>
  <canvas id="myChartmale" style="position: relative" class="dansei"></canvas>
</div>

  <fieldset>
    <legend>感想リスト（csv）</legend>
    <table>
      <tbody>
        <!-- データの出力を忘れずに-->
        <?= $str ?>
      </tbody>
    </table>
  </fieldset>

<a href="index.php">ゲストページ</a>
</main>

<footer>©たかはし</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script>
<script type="text/javascript" src="rakutenma.js" charset="UTF-8"></script>
<script type="text/javascript" src="model_ja.js" charset="UTF-8"></script>
<script type="text/javascript" src="hanzenkaku.js" charset="UTF-8"></script>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/wordCloud.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>

<script type="text/javascript" charset="UTF-8"></script>
   
   <script>
      // JSではPHPの配列を扱えないため，サーバ上でJSON形式に変換する
      const hogeArray = <?=json_encode($aryCsv)?>;
      console.log(hogeArray)
      console.log(hogeArray[8][3]);
  
//全体
    const opinion = [];
      for (let i = 0; i < hogeArray.length; i++){
                    rma_ja = new RakutenMA(model_ja);
                    rma_ja.featset = RakutenMA.default_featset_ja;
                    rma_ja.hash_func = RakutenMA.create_hash_func(15);

                    let textarea = hogeArray[i][3];
                    console.log(textarea);

                    let tokens = rma_ja.tokenize(HanZenKaku.hs2fs(HanZenKaku.hw2fw(HanZenKaku.h2z(textarea))));
                    console.log(tokens);

                        for (let i = 0; i < tokens.length; i++) {
                        console.log(tokens[i]);
                        if (tokens[i][1] === "N-n" || tokens[i][1] === "N-nc" || tokens[i][1] === "N-pn" || tokens[i][1] === "A-c" || tokens[i][1] === "A-dp") {
                            console.log(tokens[i][0]);
                            opinion.push(tokens[i][0]);

                        };
                    };
    }
    console.log(opinion);
    
                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv", am4plugins_wordCloud.WordCloud);
                var series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());

                series.accuracy = 4;
                series.step = 15;
                series.rotationThreshold = 0.7;
                series.maxCount = 500;
                series.minWordLength = 2;
                series.labels.template.margin(1, 1, 1, 1);
                series.maxFontSize = am4core.percent(30);

                series.text = `<p>${opinion}</p>`;

                series.colors = new am4core.ColorSet();
                series.colors.passOptions = {}; // makes it loop

                //series.labelsContainer.rotation = 45;
                series.angles = [0, -90];
                series.fontWeight = "700"

                setInterval(function () {
                    series.dataItems.getIndex(Math.round(Math.random() * (series.dataItems.length - 1))).setValue("value", Math.round(Math.random() * 10));
                }, 10000)


  //男性
  const opinionmale = [];
      for (let i = 0; i < hogeArray.length; i++){
        if(hogeArray[i][2]=="男性"){
          console.log(hogeArray[i][3]);

                    rma_ja = new RakutenMA(model_ja);
                    rma_ja.featset = RakutenMA.default_featset_ja;
                    rma_ja.hash_func = RakutenMA.create_hash_func(15);

                    let textareamale = hogeArray[i][3];
                    console.log(textareamale);

                    let tokens = rma_ja.tokenize(HanZenKaku.hs2fs(HanZenKaku.hw2fw(HanZenKaku.h2z(textareamale))));
                    console.log(tokens);

                    for (let i = 0; i < tokens.length; i++) {
                        console.log(tokens[i]);
                    if (tokens[i][1] === "N-n" || tokens[i][1] === "N-nc" || tokens[i][1] === "N-pn" || tokens[i][1] === "A-c" || tokens[i][1] === "A-dp") {
                        console.log(tokens[i][0]);
                        opinionmale.push(tokens[i][0]);

                        };

        }

      }}
      console.log(opinionmale);

                      // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv3", am4plugins_wordCloud.WordCloud);
                var series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());

                series.accuracy = 4;
                series.step = 15;
                series.rotationThreshold = 0.7;
                series.maxCount = 500;
                series.minWordLength = 2;
                series.labels.template.margin(1, 1, 1, 1);
                series.maxFontSize = am4core.percent(30);

                series.text = `<p>${opinionmale}</p>`;

                series.colors = new am4core.ColorSet();
                series.colors.passOptions = {}; // makes it loop

                //series.labelsContainer.rotation = 45;
                series.angles = [0, -90];
                series.fontWeight = "700"

                setInterval(function () {
                    series.dataItems.getIndex(Math.round(Math.random() * (series.dataItems.length - 1))).setValue("value", Math.round(Math.random() * 10));
                }, 10000)
  

  //女性

  const opinionfemale = [];
      for (let i = 0; i < hogeArray.length; i++){
        if(hogeArray[i][2]=="女性"){
          console.log(hogeArray[i][3]);

                    rma_ja = new RakutenMA(model_ja);
                    rma_ja.featset = RakutenMA.default_featset_ja;
                    rma_ja.hash_func = RakutenMA.create_hash_func(15);

                    let textareafemale = hogeArray[i][3];
                    console.log(textareafemale);

                    let tokens = rma_ja.tokenize(HanZenKaku.hs2fs(HanZenKaku.hw2fw(HanZenKaku.h2z(textareafemale))));
                    console.log(tokens);

                    for (let i = 0; i < tokens.length; i++) {
                        console.log(tokens[i]);
                    if (tokens[i][1] === "N-n" || tokens[i][1] === "N-nc" || tokens[i][1] === "N-pn" || tokens[i][1] === "A-c" || tokens[i][1] === "A-dp") {
                        console.log(tokens[i][0]);
                        opinionfemale.push(tokens[i][0]);

                        };

        }

      }}
      console.log(opinionfemale);

                      // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv2", am4plugins_wordCloud.WordCloud);
                var series = chart.series.push(new am4plugins_wordCloud.WordCloudSeries());

                series.accuracy = 4;
                series.step = 15;
                series.rotationThreshold = 0.7;
                series.maxCount = 500;
                series.minWordLength = 2;
                series.labels.template.margin(1, 1, 1, 1);
                series.maxFontSize = am4core.percent(30);

                series.text = `<p>${opinionfemale}</p>`;

                series.colors = new am4core.ColorSet();
                series.colors.passOptions = {}; // makes it loop

                //series.labelsContainer.rotation = 45;
                series.angles = [0, -90];
                series.fontWeight = "700"

                setInterval(function () {
                    series.dataItems.getIndex(Math.round(Math.random() * (series.dataItems.length - 1))).setValue("value", Math.round(Math.random() * 10));
                }, 10000)
  
//割合グラフ（全体）

            const count = {
            living: 0,
            kichin: 0,
            bed: 0,
            toilet: 0,
            };
          
          for (let i = 0; i < hogeArray.length; i++){
          if(hogeArray[i][4]=="リビング"){
            count["living"]++;
          } else if(hogeArray[i][4]=="キッチン"){
            count["kichin"]++;
          } else if(hogeArray[i][4]=="洋室"){
            count["bed"]++;
          } else if(hogeArray[i][4]=="トイレ"){
            count["toilet"]++;
          }
        }
          console.log(count["living"]);


          var ctx = document.getElementById("myChart");
          var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
          labels: ["リビング", "キッチン", "洋室", "トイレ"],
          datasets: [{
          backgroundColor: [
              "#BB5179",
              "#FAFF67",
              "#58A27C",
              "#3C00FF"
          ],
          data: [count["living"], count["kichin"], count["bed"], count["toilet"]]
      }]
    },
    options: {
      title: {
        display: true,
        text: '印象に残った場所：全体'
      }
    }
  });


//割合グラフ（女性）
          const countfemale = {
          living: 0,
          kichin: 0,
          bed: 0,
          toilet: 0,
            };

      for (let i = 0; i < hogeArray.length; i++){
        if(hogeArray[i][2]=="女性"){
          if(hogeArray[i][4]=="リビング"){
            countfemale["living"]++;
          } else if(hogeArray[i][4]=="キッチン"){
            countfemale["kichin"]++;
          } else if(hogeArray[i][4]=="洋室"){
            countfemale["bed"]++;
          } else if(hogeArray[i][4]=="トイレ"){
            countfemale["toilet"]++;
          }
        };
      }

          var ctx = document.getElementById("myChartfemale");
          var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
          labels: ["リビング", "キッチン", "洋室", "トイレ"],
          datasets: [{
          backgroundColor: [
              "#BB5179",
              "#FAFF67",
              "#58A27C",
              "#3C00FF"
          ],
          data: [countfemale["living"], countfemale["kichin"], countfemale["bed"], countfemale["toilet"]]
      }]
    },
    options: {
      title: {
        display: true,
        text: '印象に残った場所：女性'
      }
    }
  });    


//割合グラフ（男性）

          const countmale = {
          living: 0,
          kichin: 0,
          bed: 0,
          toilet: 0,
            };

      for (let i = 0; i < hogeArray.length; i++){
        if(hogeArray[i][2]=="男性"){
          if(hogeArray[i][4]=="リビング"){
            countmale["living"]++;
          } else if(hogeArray[i][4]=="キッチン"){
            countmale["kichin"]++;
          } else if(hogeArray[i][4]=="洋室"){
            countmale["bed"]++;
          } else if(hogeArray[i][4]=="トイレ"){
            countmale["toilet"]++;
          }
        };
      }

          var ctx = document.getElementById("myChartmale");
          var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
          labels: ["リビング", "キッチン", "洋室", "トイレ"],
          datasets: [{
          backgroundColor: [
              "#BB5179",
              "#FAFF67",
              "#58A27C",
              "#3C00FF"
          ],
          data: [countmale["living"], countmale["kichin"], countmale["bed"], countmale["toilet"]]
      }]
    },
    options: {
      title: {
        display: true,
        text: '印象に残った場所：男性'
      }
    }
  });    


</script>
</body>


</html>