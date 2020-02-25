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

  $reply_help=[
    "type"=> "template",
  "altText"=> "this is a carousel template",
  "template"=> [
    "type"=> "carousel",
    "actions"=> [],
    "columns"=> [
      [
        "thumbnailImageUrl"=> "https://raw.githubusercontent.com/nuttlovenutt00/nutt/master/3.jpg",
        "title"=> "มอคค่า",
        "text"=> "วิธีการสั่ง พิมพ์ P101@จำนวนที่ต้องการ",
        "actions"=> [
          [
            "type"=> "message",
            "label"=> "Code : P100",
            "text"=> "1"
          ]
        ]
      ],
      [
        "thumbnailImageUrl"=> "https://raw.githubusercontent.com/nuttlovenutt00/nutt/master/3.jpg",
        "title"=> "มอคค่า",
        "text"=> "วิธีการสั่ง พิมพ์ P101@จำนวนที่ต้องการ ",
        "actions"=> [
          [
            "type"=> "message",
            "label"=> "Code : P101",
            "text"=> "Action 1"
          ]
        ]
      ]
    ]
  ]
  ];
    
  $replyJson["messages"][0] = $reply_help;
  
  

   
  //ส่งค่าทั้งหมดกลับไปหา Line
  $encodeJson = json_encode($replyJson);
  $results = sendMessage($encodeJson,$lineData);
  echo $results;
  http_response_code(200);
?>
