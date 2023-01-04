<html>
  <head>
    <title>Bing壁纸下载</title>
  </head>
  <body>
<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(0); 
require('inc/inc.php');
$url_pre = 'https://cn.bing.com';
    getDayImg('-1');//保存最近1-7天的json数据
    //getDayImg('7');//保存最近8-16天的json数据
    $pageSize = '12';//每页显示数量
    $page = @$_GET['p'] > 1 ? @$_GET['p'] : 1;//当前页码
    $now = date('Ymd');//当前日期
    $pre = $page - 1;
    $next = $page + 1;
    echo "<div style='width:100%;margin:0 auto;text-align:center;'><p><a href='/?p=".$pre."'>前一页</a>&nbsp;<a href='/'>首页</a>&nbsp;<a href='/?p=".$next."'>后一页</a></p>";
    ?>
<ul style="list-style:none;max-width:1200px;margin:0 auto;padding:0;">
<?php
    $torder = ($page-1)*$pageSize;//每页第一个排序.
    $tdate = date('Ymd',strtotime($now.'-'.$torder.' day'));//每页第一个日期.
    for($i=0;$i<$pageSize;$i++){
      $t = $i - 1;
      $name = date('Ymd',strtotime($tdate.'-'.$t.' day'));
      if(!file_exists('json/'.$tdate.'.json')) {getDayImg('-1');exit('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><script>alert("没有数据呀！请刷新后再试.");window.history.back(-1);</script>');}//如果第一个不存在.
      if(file_exists('json/'.$name.'.json')){
          $json_file = fopen('json/'.$name.'.json','r');
          $tfile = json_decode(fgets($json_file), true);
          fclose($json_file);
          $timg = $url_pre.$tfile['url'];
          $turl = $tfile['info']['url'];
          $tadd = getNeedBetween($tfile['copyright'],'，','(');//count($turl)!=0 ? "[".$turl['cy'].",".$turl['ct'].']':'';
          if (!file_exists('images/simg/'.$name.'.jpg')) $nimg = save($timg,$name);//如果图片不存在,则下载图片
          else $nimg = 'images/simg/'.$name.'.jpg';
          $con = "<li style='display: inline-block;width:96%;margin: 2%;max-width:320px;overflow: hidden;border: 1px solid #e3e3e3;padding: 5px;'><a href='img.php?img=".$name."' target='_blank' alt='".$tfile['copyright']."'><img src='".$nimg."' style='' ></a><p style='height:20px;'>".date('Y-m-d',strtotime($tfile['enddate']))."</p><p style='height:20px;'>".$tadd."</p></li>";
          echo $con;
      }
    }
    echo "<div style='width:100%;margin:0 auto;text-align:center;'><p><a href='/?p=".$pre."'>前一页</a>&nbsp;&nbsp;<a href='/?p=".$next."'>后一页</a></p>";
    echo "<p style='width:100%;margin:0 auto;text-align:center;'><a style='text-decoration: none;' href='http://www.imgurl.com.cn/'>bing壁纸</a>&nbsp;|&nbsp;<a style='text-decoration: none;' href='https://github.com/shadoweb/bing-image'>本站源码</a></p>";
?>
    </ul>
</body>
  </html>