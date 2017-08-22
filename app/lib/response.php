<?php
namespace App\Lib;
class Response
{
	public $result     = null;
	public $response   = false;
	public $message    = 'Ocurrio un error inesperado. Vuelve a intentarlo. Si el problema persiste contacte al departamento de tecnología';
  	public $token      = null;
  	public $logout     = false;
	public function SetResponse($response, $m = '')
	{
		$this->response = $response;
		$this->message  = $m;
		if(!$response && $m = '') $this->response = 'Ocurrio un error inesperado';
	}
    public function SetToken($t) { $this->token = $t; }
    public function SetLogout($logout = true) { $this->logout = $logout; }
}

?>
