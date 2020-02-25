<?php

  //รับค่าจาก line
  $LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);
  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];

  //เชื่อมต่อฐานข้อมูล
  $servername = "37.59.55.185";
  $username = "Z01XVlWSlA";
  $password = "ogqvLgVKmd";
  $dbname = "Z01XVlWSlA";
  $mysql = new mysqli($servername, $username, $password, $dbname);
  mysqli_set_charset($mysql, "utf8");
  


  //ฟังก์ชั่นการส่งข้อมูลไปหา Line
  $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
  $lineData['AccessToken'] = "z+gWGvZH82J5R807gHMcwflDHs+az7O80eKEoHDWeE/xxTaRHQvy9l6CNOEyWp+aPJzjWJqIpcJmgXNjfE6ODrViiVfNJzTdSf7DsexV7uvW/kPqdKCYoGdAlAymF1YUOG1j6Yzyh6ZP5vPYeleCzAdB04t89/1O/w1cDnyilFU=";
  $replyJson["replyToken"] = $replyToken;

  function sendMessage($replyJson, $sendInfo){
          $ch = curl_init($sendInfo["URL"]);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLINFO_HEADER_OUT, true);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Authorization: Bearer ' . $sendInfo["AccessToken"])
              );
          curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
          $result = curl_exec($ch);
          curl_close($ch);
    return $result;
  }



  
  
  

   
  //ส่งค่าทั้งหมดกลับไปหา Line
  $encodeJson = json_encode($replyJson);
  $results = sendMessage($encodeJson,$lineData);
  echo $results;
  http_response_code(200);
?>
