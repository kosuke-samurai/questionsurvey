<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>うちの家に関するアンケート</title>
</head>
<body>
    <header>
        <h1>うちの家に関するアンケート</h1>
        <p>正直にお答えください</p>
    </header>

    <main>
     <form action="create.php" method="POST">
      
     <dl class="input">
      <dt class="required">お名前</dt>  
      <dd><input type="text" name="name" class="info" required></dd>
    
      <dt class="required">年齢</dt>
      <dd><input type="text" inputmode="numeric" pattern="^[1-9][0-9]*$" name="old" class="infoold" required><span class="margin">歳</span></dd>

      <dt class="required">性別</dt>
      <dd>
        <ul>
          <li>
        <label><input type="radio" name="sex" value="女性" class="sex" required>女性</label>
        </li>
        <li>
        <label><input type="radio" name="sex" value="男性" class="sex" required>男性</label>
        </li>
        <li>
        <label><input type="radio" name="sex" value="その他" class="sex" required>その他</label> 
        </li> 
        </ul>           
      </dd>

      <dt class="required">最も印象に残った場所は</dt>
      <dd>
        <ul>
          <li>
        <label><input type="radio" name="location" value="リビング" class="sex" required>リビング</label>
        </li> 
        <li>
        <label><input type="radio" name="location" value="キッチン" class="sex" required>キッチン</label>
        </li> 
        <li>
        <label><input type="radio" name="location" value="洋室" class="sex" required>洋室</label>
        </li> 
        <li>
        <label><input type="radio" name="location" value="トイレ" class="sex" required>トイレ</label> 
        </li> 
        </ul>               
      </dd>

      <dt class="required">感想を教えてください</dt>
      <dd><textarea type="textarea" name="opinion" cols="30" rows="10" class="info" required></textarea></dd>
    

      <div class="button">
        <button>感想を送る</button>
      </div>
      </dl>

    

  </form>

    
  <a href="read.php">管理者用ページ</a>
   </main>
   <footer>@高橋</footer>
</body>
</html>