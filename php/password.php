<?php
    $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP1234567890!";
    $max=10;
    $size=StrLen($chars)-1;
    $password=null;
    while($max--){
      $password.=$chars[rand(0,$size)];
    }
    $sPassword = password_hash($password, PASSWORD_DEFAULT);
     ?>
