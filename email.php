<?php
    //发送邮箱验证码
    public function email($toemail,$toname,$account,$userpassword)
    {
    //平台邮箱与授权登录码
    $username = config('mail_config.username');
    $password = config('mail_config.password');
    //引入PHPMailer的三个文件
    Loader::import('PHPMailer.src.PHPMailer', EXTEND_PATH);
    Loader::import('PHPMailer.src.SMTP', EXTEND_PATH);
    Loader::import('PHPMailer.src.Exception', EXTEND_PATH);
    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();// 使用SMTP服务
    $mail->IsHTML(true); //支持html格式内容
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
    $mail->SMTPAuth = true;// 是否使用身份验证
    $mail->Username = $username;// 发送方的QQ邮箱用户名，就是自己的邮箱名
    $mail->Password = $password;// 发送方的邮箱密码，不是登录密码,是qq的第三方授权登录码,要自己去开启,在邮箱的设置->账户->POP3/IMAP/SMTP/Exchange/CardDAV/CalDAV服务 里面
    $mail->SMTPSecure = "ssl";// 使用ssl协议方式,
    $mail->Port = 465;// QQ邮箱的ssl协议方式端口号是465/587

    $mail->setFrom($username,"综合营销平台");// 设置发件人信息，如邮件格式说明中的发件人,
    $mail->addAddress($toemail,$toname);// 设置收件人信息，如邮件格式说明中的收件人
    $mail->addReplyTo($username,"Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
    //$mail->addCC("xxx@163.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址(这个人也能收到邮件)
    //$mail->addBCC("xxx@163.com");// 设置秘密抄送人(这个人也能收到邮件)
    //$mail->addAttachment("bug0.jpg");// 添加附件


    $mail->Subject = "您好！$toname";// 邮件标题
    $mail->Body = '<div align="center">
        你好, <b>朋友</b>! <br/>
        微信综合营销商家管理后台：<a href="http://zongheyingxiao.wsandos.com">http://zongheyingxiao.wsandos.com</a><br/>
        账户：'.$account.'<br/>
        密码：'.$userpassword.'
    </div>'; //邮件主体内容
    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

    if(!$mail->send()){// 发送邮件
    echo "Message could not be sent.";
    echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
    }else{
    echo '发送成功';
    }
    }

    public function ysmail(){
    $to      = '2625407061@qq.com';
    $subject = 'the subject test';
    $message = 'hello';
    ini_set('SMTP','smtp.163.com');//发件SMTP服务器
    ini_set('smtp_port',25);//发件SMTP服务器端口
    ini_set('sendmail_from',"13669586274@163.com");//发件人邮箱

    $ret = mail($to, $subject, $message);
    echo $ret;
    /**
    Warning: mail() [function.mail]: SMTP server response: 553 authentication is required,smtp2,DNGowKD7v5BTDo9NnplVBA--.1171S2 1301220947 inD:/www/Zend/email/email.php on line 9
    需要验证信息，怎么写验证信息呢？在哪里配置呢？
    使用mail()函数发送邮件就必须要有一台无需SMTP验证就可以发信的邮件服务器。但现在的SMTP邮件服务器基本上都是需要验证的，所以要想使用它发邮件就只能自己在本地搭一个不需要验证的SMTP服务器。
    结论：使用mail()函数发送邮件，就必须要有一台不需要验证的SMTP服务器。
    **/
}