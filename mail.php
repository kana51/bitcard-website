<?php


//mailer利用
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


if(isset($_POST['name'])) $name = htmlspecialchars($_POST['name']);
if(isset($_POST['office'])) $office = htmlspecialchars($_POST['office']);
if(isset($_POST['email'])) $email = htmlspecialchars($_POST['email']);
if(isset($_POST['tel'])) $tel = htmlspecialchars($_POST['tel']);
if(isset($_POST['text'])) $text = htmlspecialchars($_POST['text']);

//社内用メール設定
$body1 = <<<EOT
ご担当者様
お客様より以下内容で、お問い合わせがありました。
ご対応のほどよろしくお願いいたします。

――お客様情報――――――――
お名前： {$name}
会社名： {$office}
Email： {$email}
TEL： {$tel}
――お問い合わせ内容―――――
{$text}
EOT;

//お客さま用メール設定
$body2 =  <<<EOT
{$name}様
お問い合わせいただきありがとうございました。

こちらのメールは自動送信されています。
後日担当者よりご連絡させていただきます。

――お客様情報――――――――
お名前： {$name}
会社名： {$office}
Email： {$email}
TEL： {$tel}
――お問い合わせ内容―――――
{$text}

*********************************************
このメールに関するお問い合わせ先
株式会社bitcard
TEL:050-5846-6127
*********************************************
EOT;




// //送信元設定（HDR）
$itj_email = "kana.51.tachi@gmail.com";
$itj_password = "H8Sgi2LS";
$itj_name = "株式会社bitcard";



//社内(info)/////////////////////////////////////////////////////////////////
//phpmailer利用
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;//debugするときは3にするとよい
//gmailの設定
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->CharSet = "UTF-8";
$mail->Username = $itj_email;
$mail->Password = $itj_password;
$mail->setFrom($itj_email, $itj_name);
$mail->addReplyTo($itj_email, $itj_name);


//送信先
$to = $itj_email;
$toName = $itj_name;
$subject = "お問い合わせがありました";
$mail->addAddress($itj_email, $itj_name);
$mail->Subject = $subject;
$mail->Body = $body1;

?>


<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact | bitcard</title>
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <nav class="navbar navbar-default navbar-fixed-top">
    <!-- container -->
    <div class="container">
    <!-- nav-header -->
      <div class="navbar-header">
          <!-- logo -->
        <a href="#"><img src="image/logo.png" id="logo"></a>
          <!-- toggle -->
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
      </div><!-- end nav-header -->
      <!-- top menu -->
      <div class="collapse navbar-collapse" id="top-nav">
          <!-- left -->
          <ul class="nav navbar-nav">
            <li><a href="about.html" class="about">About</a></li>
            <li><a href="index.html#vision" class="vision">Vision</a></li>
            <li><a href="index.html#contact" class="contact">Contact</a></li>
          </ul>
      </div><!-- end top menu -->
    </div><!-- end container -->
  </nav><!-- end nav -->
</header>


<div class="wrapper">
  <div class="container">
    <div class="contents-title">
      <h2 class="content-title">Contact</h2>
    </div>
    <div class="contents-text">
      <?php
        if (!$mail->send()) {

          echo "メール送信に失敗しました。: " . $mail->ErrorInfo;

        } else {

          //問い合わせした人///////////////////////////////////////////////////////////////////
          //phpmailer利用
          $mail = new PHPMailer;
          $mail->isSMTP();
          $mail->SMTPDebug = 0;//debugするときは3にするとよい
          //gmailの設定
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = 587;
          $mail->SMTPSecure = 'tls';
          $mail->SMTPAuth = true;
          $mail->CharSet = "UTF-8";
          $mail->Username = $itj_email;
          $mail->Password = $itj_password;
          $mail->setFrom($itj_email, $itj_name);
          $mail->addReplyTo($itj_email, $itj_name);

          //送信先
          $to = $email;
          $toName = $name;
          $subject = "お問い合わせありがとうございます";
          $mail->addAddress($to, $toName);
          $mail->Subject = $subject;
          $mail->Body = $body2;

          if (!$mail->send()) {
              echo "メール送信に失敗しました。<br>お手数ですが、もう一度最初からやり直してください。<br>お急ぎの方は TEL:050-5846-6127 までご連絡ください。" ;
          } else {
              echo "お問い合わせありがとうございました。<br>担当者よりご連絡させていただきますので、今しばらくお待ち下さい。";

          }
          ///////////////////////////////////////////////////////////////////

        }
      ?>

    </div>
  </div><!-- end container -->
</div><!-- end box -->





<!-- footer -->

<footer>
  2018&copy; bitcard,inc.
</footer>

<!-- script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
