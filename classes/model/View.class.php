<?php
class View{

	private $layout;

	public function __construct($layout){
		$this->layout = $layout;
	}

	public static function setLayout($layout){
		self::$layout = $layout;
	}

	public function renderPage($name, $args = []){
		ob_start();
		$args = self::escapeHTML($args);
		extract($args);

		if (isset($args['msg'])) $msg = $this->createToastr($args['msgTitle'], $args['msg'], $args['msgType']);
		include BP."classes/view/".$name.".phtml";
		$content = ob_get_clean();

		include BP."/classes/view/".$this->layout.".phtml";
//		phpinfo();
	//	echo $_SERVER['REQUEST_METHOD'];
	//	echo " ";
	//	var_dump($_GET);
	}

	private function createToastr($msgTitle = '', $msg = '', $msgType = 'error'){
		if(empty($msg)) return $msg;

		return "<script>
				toastr.options={
					'closeButton':true,
					'positionClass': 'toast-top-center'
				}
				toastr['$msgType']('$msg', '$msgTitle')
				 </script>";
	}

	private static function escapeHTML($values = []){
		foreach($values as $key => $value){
			if ($key == 'images'){
				foreach($value as $image){
					$image->imageTitle = htmlspecialchars($image->imageTitle);
					$image->imageLocation = htmlspecialchars($image->imageLocation);
				}
			}
			else{
				$values[$key] = htmlspecialchars($value);
			}
		}

		return $values;
	}



}
