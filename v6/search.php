<?php
  require_once("dbtools.inc.php");
  header("Content-type: text/html; charset=utf-8");
  
  //取得表單資料
  $account = $_POST["account"]; 
  $name = $_POST["name"];
  // $show_method = $_POST["show_method"]; 

  //建立資料連接
  $link = create_connection();
			
  //檢查查詢的帳號是否存在
  $sql = "SELECT name, password FROM users WHERE 
          account = '$account' AND name = '$name'";
  $result = execute_sql($link, "wandering", $sql);

  //如果帳號不存在
  if (mysqli_num_rows($result) == 0)
  {
    //顯示訊息告知使用者，查詢的帳號並不存在
    echo "<script type='text/javascript'>
            alert('您所查詢的資料不存在，請檢查是否輸入錯誤。');
            history.back();
          </script>";
  }
  else  //如果帳號存在
  {
    $row = mysqli_fetch_object($result);
    $name = $row->name;
    $password = $row->password;
    $message = "
      <!doctype html>
      <html>
        <head>
          <title></title>
          <meta charset='utf-8'>
        </head>
        <body>
        <center>
          <img src='images/indexlogo.jpg'
          style='width: 125px; 
          height: 125px; 
          border-radius: 100%; 
          border: 2px solid rgb(180, 175, 175);'>
          <br><br>
          $name 您好，您的帳號資料如下：<br><br>
          帳號：$account<br>
          密碼：$password<br><br>
          <a href='login.html'>按此登入本站</a>
        </center>
        </body>
      </html>
    ";
	
    // if ($show_method == "網頁顯示")
    // {
      echo $message;   //顯示訊息告知使用者帳號密碼
    // }
    // else
    // {
    //   $subject = "=?utf-8?B?" . base64_encode("帳號通知") . "?=";
    //   $headers  = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\n";
    //   mail($account, $subject, $message, $headers);	

    //   //顯示訊息告知帳號密碼已寄至其電子郵件了
    //   echo "$name 您好，您的帳號資料已經寄至 $account<br><br>
    //         <a href='login.html'>按此登入本站</a>";				
    // }
  }

  //釋放 $result 佔用的記憶體
  mysqli_free_result($result);
		
  //關閉資料連接	
  mysqli_close($link);
?>