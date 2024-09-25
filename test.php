<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="aa.css">
    <title>觀賞魚照顧輔助系統</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        #content {
            margin-top: 80px; /* 將整個內容往下移 */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center; /* 內容置中 */
        }

        #camera-view {
            width: 80vw;
            max-width: 800px;
            height: auto;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        video {
            width: 100%;
            height: auto;
        }

        #data-table {
            width: 80vw;
            max-width: 800px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
            margin-top: 20px; /* 上方空白間距 */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .controls {
            display: flex;
            justify-content: center;
            margin-top: 0; /* 調整上邊距，使按鈕往上移動 */
            margin-bottom: 20px; /* 新增下邊距，以保持與其他元素的間距 */
        }

        .controls button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .controls button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
      function sendCommand(command) {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "proc.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function () {
              if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
              }
          };
          xhr.send("command=" + command);
      }
         function dsp() {
            var item = JSON.parse(xhr.responseText);
            var outs = "<tr class=\"text-center\"><th scope=\"col\">時間</th><th scope=\"col\">溫度</th><th scope=\"col\">渾濁度</th><th scope=\"col\">ph值</th><th scope=\"col\">導電度</th></tr>";
            for (var i = 0; i < item.length; i++) {
                outs += "<tr class=\"text-center\"><td class=\"col\">" + item[i].time + "</td><td class=\"col\">" + item[i].tem + "</td><td class=\"col\">" + item[i].dirty + "</td><td class=\"col\">" + item[i].ph + "</td><td class=\"col\">" + item[i].ec + "</td></tr>";
            }
            document.getElementById("sen").innerHTML = "<table class=\"table table-bordered \">" + outs + "</table>";
            document.getElementById("id_path").innerText = "id:" + item[0].id + " EdgeServer:" + item[0].path;
        }

  </script>
</head>

<body>
<header>
    <div class="line">
        <h1><a href="index.html">觀賞魚照顧輔助系統</a></h1>
    </div>
    <nav>
        <ul>
            <li><a href="#">最新消息</a></li>
            <li><a href="#">關於我們</a></li>
            <li><a href="reg.html">註冊</a></li>
            <li><a href="login.html">登入</a></li>
        </ul>
    </nav>
</header>

<div id="content">
    <div class="container-fluid bg-primary pt-3">
        <div class="row">
            <div id="camera-view">
                <video id="camera-video" controls preload="auto" autoplay muted data-setup="{}">
                    <source src="https://120.114.140.212/hls/stream.m3u8" type="application/vnd.apple.mpegurl m3u8">
                </video>
            </div>
        </div>
    </div>

    <div class="controls">
        <button onclick="sendCommand('up')">往上</button>
        <button onclick="sendCommand('down')">往下</button>
        <button onclick="sendCommand('left')">往左</button>
        <button onclick="sendCommand('right')">往右</button>
        <button onclick="sendCommand('stop')">停止</button>
    </div>

    <div id="data-table">
        <table>
            <thead>
                <tr>
                    <th>時間</th>
                    <th>温度</th>
                    <th>混濁度</th>
                    <th>pH值</th>
                    <th>導電度</th>
                </tr>
            </thead>
            <tbody id="dataBody">
                
            </tbody>
        </table>
    </div>

    <div id="sen"></div>
    <div id="id_path"></div>
</div>
  
<?php
require('config.php');
require('dbconfig.php');
$query = "SELECT * FROM data;";
$db_conn = db_connect("host=$DBHOST dbname=$DBNAME user=$DBUSER password=$DBPWD");
$result = db_exec($db_conn, $query);

$data = array();
while ($row = db_fetch_assoc($result)) {
    $data[] = $row;
}

db_free_result($result);
db_close($db_conn);
?>
<script>
    // 在網頁加載時自動載入數據
    window.onload = fetchData;


    function updateTable(data) {
        const tableBody = document.getElementById('dataBody');
        tableBody.innerHTML = '';

        data.forEach(row => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
          <td>${row.time}</td>
          <td>${row.tem}</td>
          <td>${row.ph}</td>
          <td>${row.dirty}</td>
          <td>${row.ec}</td>
        `;
            tableBody.appendChild(newRow);
        });
    }
</script>

</body>
</html>
