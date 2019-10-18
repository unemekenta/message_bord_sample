<html>
 <html lang = "ja">
<head>
  <meta charset = "utf-8">
</head>

<body>

  <?php
    $filename="mission_3-5.txt";
    $files=file($filename);
    // 変数の初期化
    $name = "";
    $contents = "";
    $pass = "pass";
    $edit_name = "";
    $edit_comment = "";
    $edit_number = "";
    $date = date('Y年m月d日 H:i:s');

    if (!empty($_POST['name']) && !empty($_POST['comment']) && empty($_POST['editedNo'])){
      if (!empty($_POST['pass'])){
        //入力フォームのデータを受け取る
        $name= ($_POST['name']);
        $comment = ($_POST['comment']);
        $pass = ($_POST['pass']);

        if (file_exists($filename) && !empty($_POST['name']) && !empty($_POST['comment'])){
          for ($j = 0; $j < count($files) ; $j++){//ループ処理①
            $words = explode("<>",$files[$j]);
          }
          $last =  end($files)[0];
          $num = $last + 1;
          $newdate= $num."<>".$name."<>".$comment."<>".$date."<>".$pass;
        }
        else{
          $num=1;
          $newdate= $num."<>".$name."<>".$comment."<>".$date."<>".$pass;
        }
        file_put_contents($filename, $newdate."\n", FILE_APPEND);
        echo "メッセージを送信しました";
      }else{
        echo "パスワードが違います";
      }
    }

    if(!empty($_POST['deleteNo'])){
      if (($_POST['deletepass']) == $pass){
        $delete= ($_POST['deleteNo']);
        $files = file('mission_3-5.txt');
        $fp = fopen($filename, "w");

        for ($j = 0; $j < count($files) ; $j++){
          $words = explode("<>",$files[$j]);
            if ($words[0] == $delete) {
            } else {
              fwrite($fp, $files[$j]);
            }
        }
        fclose($fp);
          echo "コメントを削除しました";
      } else{
        echo "パスワードが違います";
      }
    }


    if(!empty($_POST['editNo'])){
      if (($_POST['editpass']) == $pass){
        $files = file("mission_3-5.txt");
        for($i=0; $i<count($files);$i++){
          $ex = explode("<>",$files[$i]);
          if($ex[0] == $_POST['editNo']){
            $edit_number = $ex[0];
            $edit_name = $ex[1];
            $edit_comment = $ex[2];
          }
        }
      } else{
        echo "パスワードが違います";
      }
    }
    //編集選択終わり
    //編集機能始まり
    if(!empty($_POST['editedNo'])){
      if (($_POST['pass']) == $pass){
        $files = file($filename);
        file_put_contents($filename, "");
        for($i=0; $i<count($files);$i++){
          $plode = explode("<>",$files[$i]);
          $edit_number=$plode[0];
          $edit_name=$plode[1];
          $edit_comment=$plode[2];

          if($edit_number == $_POST['editedNo']){
            $new1 = $plode[0]."<>".($_POST['name'])."<>".($_POST['comment'])."<>".$date;
              file_put_contents($filename, $new1."\n", FILE_APPEND);
          }else{
            $new2 = $plode[0]."<>".$edit_name."<>".$edit_comment."<>".$date;
              file_put_contents($filename, $new2."\n",  FILE_APPEND);
          }
        }//ループ処理閉じ
        $edit_number = "";
        $edit_name = "";
        $edit_comment = "";
        echo "メッセージを編集しました";
      }else {
        echo "パスワードが違います";
      }
    }
    //編集機能終わり

  ?>
  <!--送信用の入力フォームを設置-->
  <form method= "post" action="">
  <input type="text" name="name" value="<?php echo $edit_name;?>" placeholder="名前"><br>
  <input type="text" name="comment" value="<?php echo $edit_comment;?>" placeholder="メッセージ"><br>
  <input type="password" name="pass" value="" placeholder="パスワード"><br>
  <input type="hidden" name="editedNo" value="<?php echo $edit_number;?>"><br>
  <input type="submit">
  </form>
  <br>

  <!--削除用の入力フォームを設置-->
  <form method= "post" action="">
  <input type="text" name="deleteNo" placeholder="削除対象番号"><br>
  <input type="password" name="deletepass" value="" placeholder="パスワード"><br>
  <input type="submit" name="delete" value="削除">
  </form>
  <br>

  <!--編集用の入力フォームを設置-->
  <form method= "post" action="">
  <input type="text" name="editNo" placeholder="編集対象番号"><br>
  <input type="password" name="editpass" value="" placeholder="パスワード"><br>
  <input type="submit" name="edit" value="編集">
  </form>
  <br>

  <?php
    $file_data = file($filename);
    foreach($file_data as $key => $value){
      $line = explode("<>",$value);
      echo $line[0]." ".$line[1]." ".$line[2]." ".$line[3]."<br>";
    }
  ?>

</body>
</html>
