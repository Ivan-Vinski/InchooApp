<?php


class View{

	private $layout;

	public function changeLayout($layout){
		$this->layout = $layout;
	}

	public static function renderPage($name, $args = []){
		ob_start();
		$args = self::escapeHTML($args);
		extract($args);

		if (isset($args['msg'])) $msg = self::createToastr($args['msg']);
		include BP."/classes/view/".$name.".phtml";
		$content = ob_get_clean();
		
		include BP."/classes/view/layout.phtml";
	


	}

	private static function createToastr($msg = ''){
		if(empty($msg)) return $msg;
		 
		return "<script>
				toastr.options={
					'closeButton':true,
					'positionClass': 'toast-top-center'
				}
				toastr['error']('$msg', 'Login')
				 </script>";
	}
	
	private static function escapeHTML($values = []){
		foreach($values as $key => $value){
			 $values[$key] = htmlspecialchars($value);
		}
		return $values;
	}



}

?>
