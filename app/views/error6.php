<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error Page</title>
  <!-- <link rel="stylesheet" href="css/error.css"> -->

  <style>
    body {
    background-color: rgb(248, 248, 248);
}
.error-body{
    width: calc(100% - 60px);
    max-width: 1200px ;
    margin: 0 auto;

}
.error-header {
    background-color: #ffff;
    padding: 30px;
    margin: 20px auto;
    width: calc(100% - 60px);
    max-width: calc(100% - 60px);
    border-radius: 2px;
    box-shadow: 1px 1px 2px #bfbfbf;
    color: rgb(42, 89, 165);
    font-size: 130%;
    font-weight: 600;
    font-family: Arial, Helvetica, sans-serif;
}
.stack-trace{
    background-color: #ffff;
    padding: 30px;
    margin: 5px auto;
    width: calc(100% - 60px);
    max-width: calc(100% - 60px);
    border-radius: 2px;
    box-shadow: 1px 1px 2px #bfbfbf;
    color: rgb(74, 87, 107);
    font-size: 100%;
    font-weight: 600;
    display: inline-block;
    font-family: Arial, Helvetica, sans-serif;
}
.stack-trace h3{
    width: 100px;
    display: flex;
}
  </style>
</head>

<body>
  <div class="error-body">
    <div class="error-header">
      <?= $exception['statusCode'] . ' ' . $exception['message'] ?>
    </div>
    <div class="stack-trace">
    <?php if(isset($exception['trace'])) foreach ($exception['trace'] as $key => $value) { ?>
        <?php
        if (isset($value['file']))
          echo 'File:     ' . $value['file'] .'<br>';

        if (isset($value['line']))
          echo 'Line:     ' . $value['line'].'<br>';

        if (isset($value['function']))
          echo 'Function: ' . $value['function'].'<br>';

          if (isset($value['class']))
          echo 'Class:    ' . $value['class'].'<hr><br>';
        ?>
    <?php }  ?>
  </div>
  </div>
</body>

</html>