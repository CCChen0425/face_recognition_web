<html>
<head>
	<meta charset="utf-8">
	<title>人脸识别</title>
<style>
	.top{
		font-family:"宋体";
		font-size:32pt;
		font-weight:bolder;
	}
	.left{
		float:left;
		border:solid 1px; 
		width:28%; 	 
		height:65%;
		margin-left:18%;
		overflow: auto; 
		position:relative;
		-webkit-box-sizing:border-box; 
		-moz-box-sizing:border-box;  
		box-sizing: border-box; 
	}
	.right{
		border:solid 1px; 
		width:30%; 	 
		height:66%;
		overflow: auto; 
		-webkit-box-sizing:border-box; 
		-moz-box-sizing:border-box;  
		box-sizing: border-box;
	}
	.foot{
		
	}
	.result{
		font-family:"宋体";
		font-size:16pt;
		font-weight:bolder;
	}
	.submitbutton{
		width:55px;
		height:30px;
	}
	#div1{
		position:absolute;
	}
	#div2{
		position:absolute;
	}
</style>
<script>
	
</script>
</head>
<body background="bg-picture.jpg">
<div class="top">
<center>
   <h1>Face Detect System</h1>
   </center>
</div>
<div class="foot">
<center>
   <form action="c.php" method="post" enctype="multipart/form-data">
    <input type="file" name="img">
    <br>（图片格式：JPG(JPEG)，PNG、图片文件大小不超过2 MB）
	<br>
    <input type="submit" name="submit" value="提交" class="submitbutton">
	</form>
</center>
</div>
<?php
	function base64EncodeImage ($image_file) {    
		$base64_image = '';    
		$image_info = getimagesize($image_file);    
		$image_data = fread(fopen($image_file, 'r'), filesize($image_file));    
		$base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));    
		return $base64_image;
	}
 if(isset($_POST['submit'])){
	$img_file=$_FILES['img']; 
	$image_path=$_FILES['img']['tmp_name'];    //图片地址  
	$fileName=$img_file['name'];
	$base64_img = base64EncodeImage($image_path);	
    $curl = curl_init();   
    curl_setopt_array($curl, array(
       CURLOPT_URL => "https://api-cn.faceplusplus.com/facepp/v3/detect",  //输入URL
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => "",
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 30,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => "POST",
	   CURLOPT_SSL_VERIFYPEER => false,
	   CURLOPT_SSL_VERIFYHOST => false,	
       CURLOPT_POSTFIELDS => array('image_base64'=>"$base64_img",'api_key'=>"V9-iTr2pNNLNjvYDHlwvAk6yp9bxstqG",'api_secret'=>"dnSV6dnNSBJmix_3xv71kDfYqhzgdPE5",'return_landmark'=>"1",'return_attributes'=>"gender,age,smiling,headpose,facequality,blur,eyestatus,emotion,ethnicity,beauty,mouthstatus,eyegaze,skinstatus"),   //输入api_key和api_secret
        CURLOPT_HTTPHEADER => array("cache-control: no-cache",),
       )); 
    $response = curl_exec($curl);
    $err = curl_error($curl);   
    curl_close($curl); 
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
		 $arr = json_decode($response , true);
		 //var_dump($arr);
		 $age = $arr['faces'][0]['attributes']['age']['value'];
		 $gender = $arr['faces'][0]['attributes']['gender']['value'];
		 $glass = $arr['faces'][0]['attributes']['glass']['value'];
		 $smile = $arr['faces'][0]['attributes']['smile']['value'];
		 $ethnicity = $arr['faces'][0]['attributes']['ethnicity']['value'];
		 $beauty = $arr['faces'][0]['attributes']['beauty']['male_score'];
		 $width=$arr['faces'][0]['face_rectangle']['width'];
		 $height=$arr['faces'][0]['face_rectangle']['height'];
		 $x=$arr['faces'][0]['face_rectangle']['left'];
		 $y=$arr['faces'][0]['face_rectangle']['top'];
		 echo "<div class='left'>
				   <div id='div1'>
						<img src='faces/$fileName'>
				   </div>
				   <div id='div2'>
					   <canvas id='tCanvas' width='$width' height='$height' style='margin-left:$x;margin-top:$y;border:1px solid #FF0000'>
					   </canvas>
				   </div>
			   </div>";
		 echo "<div class='right'><div class='result'>检测结果如下:</div>
				<br>
				<div class='age'>年龄: $age</div>
				<div class='gender'>性别: $gender</div>
				<div class='glass'>是否有戴眼镜: $glass</div>
				<div class='smile'>笑容程度:$smile(0~100)</div>
				<div class='ethnicity'>种族: $ethnicity</div>
				<div class='beauty'>颜值: $beauty</div>
				</div>";
		 }
 }
?>  
</body>
</html>
