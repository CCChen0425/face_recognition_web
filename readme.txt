一 、概述 

1.1网站功能：点击‘选择文件’上传人脸图片，再点
‘提交’按钮，即可在下方显示人脸检测结果。
1.2采用技术：Face++人脸接口。

二、需求分析

2.1   用来检测人脸

三、详细设计

3.1设计构思：
  将HTML和PHP写在一起，都写在php文件上，HTML中表单提交直接提交当前页面。此处是为了简化代码，方便实现。
3.2设计步骤：
  1.在HTML中写一个表单，表单中input一个file类型，给其name=“img”。
  2.用if(isset($_POST['submit'])){.....}确保表单提交之后，再实行PHP部分。
  3.function base64EncodeImage实现将接收到的图片转化为64编码信息，方便接口调用。
  4.$curl = curl_init()到curl_close($curl)部分调用FACE++接口。
  5.用json_decode将获得的json数据转化为php语言中的数组形式，然后即可调用其中数据。
  6.用echo输出两个div，左边显示图片，右边显示检测结果，再通过css进行布局和美化。

四、功能实现

  4.1首先在谷歌浏览器上输入localhost/c.php，登入页面。
  4.2再桌面上创建一个faces文件夹用来储存人脸图片。
  将其复制到Apache htdocs目录中，这样可显示图片。
  4.3点击‘选择文件’，再选好图片。
  4.4点击‘提交’按钮，即可在下方区域显示结果。