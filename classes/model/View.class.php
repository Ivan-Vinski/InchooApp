<?php
class View{

	private $layout;
	private $session;

	public function __construct($layout){
		$this->layout = $layout;
	}

	public static function setLayout($layout){
		self::$layout = $layout;
	}

	public function renderPage($name, $args = []){
		ob_start();
		//$args = self::escapeHTML($args);
		extract($args);

		if (isset($args['msg'])) $msg = self::createToastr($args['msgTitle'], $args['msg'], $args['msgType']);
		include BP."/classes/view/".$name.".phtml";
		$content = ob_get_clean();

		include BP."/classes/view/".$this->layout.".phtml";
	}

	private static function createToastr($msgTitle = '', $msg = '', $msgType = 'error'){
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
			 $values[$key] = htmlspecialchars($value);
		}
		return $values;
	}



}
