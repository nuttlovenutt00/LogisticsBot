<?php

  //รับค่าจาก line
  $LINEData = file_get_contents('php://input');
  $jsonData = json_decode($LINEData,true);
  $replyToken = $jsonData["events"][0]["replyToken"];
  $userID = $jsonData["events"][0]["source"]["userId"];
  $text = $jsonData["events"][0]["message"]["text"];
  $timestamp = $jsonData["events"][0]["timestamp"];




  //ฟังก์ชั่นการส่งข้อมูลไปหา Line
  $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
  $lineData['AccessToken'] = "T+9F0YKst4Zk/YcbVrHYSA8RLAsS/VCBKmSOofn50h3rN+N+Za9xc76ffwAFGWeTPJzjWJqIpcJmgXNjfE6ODrViiVfNJzTdSf7DsexV7uus0z67cD4V2cIiCRCjGdzrEnlkbB5DC4jwD2AYNMf7nAdB04t89/1O/w1cDnyilFU=";
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

  if($text=="ขอลิ้งเข้าเว็บไซต์"){
       $reply_help=[
  

  "type"=> "flex",
  "altText"=> "Flex Message",
  "contents"=> [
    "type"=> "bubble",
    "hero"=> [
      "type"=> "image",
      "url"=> "https://raw.githubusercontent.com/nuttlovenutt00/LogisticsBot/master/161595-OVE4FY-964_edit.jpg",
      "size"=> "full",
      "aspectRatio"=> "20:13",
      "aspectMode"=> "cover"
    ],
    "footer"=> [
      "type"=> "box",
      "layout"=> "vertical",
      "flex"=> 0,
      "spacing"=> "sm",
      "contents"=> [
        [
          "type"=> "button",
          "action"=> [
            "type"=> "uri",
            "label"=> "WEBSITE",
            "uri"=> "http://ttcctv.dyndns.org:8088/Logistic/Driver/userid/".$userID
          ],
          "color"=> "#F97913",
          "height"=> "sm",
          "style"=> "primary"
        ]
      ]
    ]
  ]
  ];
  }elseif( strpos( $text, "+" )!==FALSE){
      //เชื่อมต่อฐานข้อมูล
    $servername = "37.59.55.185";
    $username = "e9y0ihR9wE";
    $password = "LQ7rvFsdA8";
    $dbname = "e9y0ihR9wE";
    $mysql = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($mysql, "utf8");

    date_default_timezone_set("Asia/Bangkok");
    $datetime=date("Y-m-d");
    $time=date("H:i:s"); 


    $mysql->query("INSERT INTO `LOG`(`UserID`, `Text`,`date`, `time`) VALUES ('$userID','$text','$datetime','$time')");

      $reply_help=[ 
            "type"=> "text",
           "text"=> "ระบบได้บันทึกข้อมูลของท่านเรียบร้อยแล้ว"
      ];
  }

 
    
  $replyJson["messages"][0] = $reply_help;
  
  

   
  //ส่งค่าทั้งหมดกลับไปหา Line
  $encodeJson = json_encode($replyJson);
  $results = sendMessage($encodeJson,$lineData);
  echo $results;
  http_response_code(200);
?>
