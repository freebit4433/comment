<?php
header("content-type:image/png");
session_start();
/*************************
*
*在这里要实现的功能：
*1.实例化验证码类，获得验证码对象；
*2.从这个对象获取这个验证码的字符值，把这个值存入SESSION，然后在login.php这个脚本里面
比对POST过来的用户输入的验证码字符值与SESSION里面的字符值是否相同，达到验证的目的；
*3.从这个对象里面获得验证码图像，从这里echo出去
*
**************************/
//推荐4位长度，50*20尺寸
$vCode = new Vcode(60,20,4,1);
$vCodeString = $vCode->achieveString();

$_SESSION['vcode'] = $vCodeString;
$vCode->achieveImage();
$vCode = NULL;

class Vcode{
	private $width;
	private $height;
	//验证码位数
	private $bitNum;
	//复杂度，1：全数字，2：数字字母组合
	private $complexity;
	//验证码字符值
	private $vCodeString;

	function __construct($width,$height,$bitNum,$complexity){
		$this->width = $width;
		$this->height = $height;
		$this->bitNum = $bitNum;
		$this->complexity = $complexity;
	}

	public function achieveString(){
		switch ($this->complexity) {
			case 1:
				//全数字类型
				for ($i=0; $i < $this->bitNum; $i++) { 
					//循环bitNum次，随机获取bitNum位的数字字符串
					$random = rand(0,9);
					$this->vCodeString .= "{$random}";
				}
				return $this->vCodeString;
				break;
			case 2:
				//数字字符混合类型
				for ($i=0; $i < $this->bitNum; $i++) { 
					$random = rand(0,1);
					if ($random) {
						$random = rand(0,9);
						$this->vCodeString .= "{$random}";
					}else{
						$random = rand(65,90);
						$this->vCodeString .= chr($random);
					}
				}
				return $this->vCodeString;
				break;
			default:
				# code...
				break;
		}
	}

	public function achieveImage(){
		$image = imagecreate($this->width,$this->height);
		$background = imagecolorallocate($image,255,255,255);
		$fontcolor = imagecolorallocate($image, 0, 0, 0);
		imagerectangle($image, 0, 0, $this->width-1, $this->height-1, $fontcolor);

		for ($i=0; $i < 120; $i++) { 
			$color = imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
			imagesetpixel($image,rand(0,$this->width), rand(0,$this->height), $color);
		}
		for ($i=0; $i < 5; $i++) { 
			$color = imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
			imagearc($image,rand(-15,$this->width),rand(-20,$this->height),rand(30,100),rand(20,100),10, 100,$color);
		}

		$char = str_split($this->vCodeString);
		$distance = $this->width/($this->bitNum+1);
		for ($i=0; $i < $this->bitNum; $i++) { 
			imagechar($image,5,$i*$distance+5, 2, $char[$i],$fontcolor);
		}

		imagepng($image);
		imagedestroy($image);
	}


}



?>