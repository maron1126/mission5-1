  <html>
    <head>
       <meta charset="UTF-8">
       <title>mission5-1</title>
    </head>
    
    <body>





<?php

//DB接続設定
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));


//テーブル作る
$sql="CREATE TABLE IF NOT EXISTS postdata"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME"
.");";
$stmt=$pdo->query($sql);


//新規投稿
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["hidden"])){
$sql=$pdo->prepare("INSERT INTO postdata(name,comment,date) VALUES(:name, :comment, :date)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':date',$date,PDO::PARAM_STR);
$name=$_POST["name"];
$comment=$_POST["comment"];
$date=date("Y-m-d H:i:s");
$sql->execute();
}




//削除機能
if(!empty($_POST["Dnum"])){
    

$Did=$_POST["Dnum"];
$sql='delete from postdata where id=:id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$Did,PDO::PARAM_INT);
$stmt->execute();



}

//編集機能


    //編集選択機能
    if(!empty($_POST["Enum"])){
    
        $Eid=$_POST["Enum"];
        $sql='SELECT * FROM postdata where id=:id';  //テーブルからあるidのとこだけを抽出
        $stmt=$pdo->prepare($sql); //準備
        $stmt->bindParam(':id',$Eid,PDO::PARAM_INT); //「あるid」に$Eidすなわち送信された編集番号を指定
        $stmt->execute();
        $results=$stmt->fetchAll(); //上記の結果を全て取り出して、それを$resultと定義
        foreach($results as $row){
    
                 $editNumber=$row['id'];
                 $editName=$row['name'];
                 $editComment=$row['comment'];
                 

        }
        
    

    }//if(!empty($_POST["Enum"]))
    else{
        $editNumber='';
        $editName='';
        $editComment='';
    
    }
    
    //編集実行機能
    if(!empty($_POST["hidden"])){
        
        $Editid=$_POST["hidden"];
        $Editname=$_POST["name"];
        $Editcomment=$_POST["comment"];
        $date=date("Y-m-d H:i:s");
        
    $sql='UPDATE postdata SET name=:name,comment=:comment, date=:date WHERE id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':name',$Editname,PDO::PARAM_STR);
    $stmt->bindParam(':comment',$Editcomment,PDO::PARAM_STR);
    $stmt->bindParam(':id',$Editid,PDO::PARAM_INT);
    $stmt->bindParam(':date',$date,PDO::PARAM_STR);
    $stmt->execute();
        
        
    }

?>

      <form action=""  method="post">
         <p>
         <input type="text" name="name" placeholder="名前" value="<?php echo $editName;?>">
         <input type="text" name="comment" placeholder="コメント" value="<?php echo $editComment;?>">
         <input type="hidden" name="hidden" value="<?php echo $editNumber;?>">
         <input type="submit" name="submit">
         </p>
         
         <p>
         <input type="number" name="Dnum" placeholder="削除対象番号">
         <input type="submit" name="submit">
         </p>
         
         <p>
         <input type="number"  name="Enum" placeholder="編集対象番号">
         <input type="submit"  name="submit">
         </p>
      </form>
        
<?php        
 


//ブラウザに表示
$sql='SELECT * FROM postdata';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
    
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].',';
    echo $row['date'].'<br>';
    echo "<hr>";


}




?>

    </body>
    
    
</html> 

