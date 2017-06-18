<?php
class Logger
{
	//статические переменные
	public static $PATH;
	protected static $loggers=array();
	protected $name;
	protected $file;
	protected $fp;
	protected $toLog; // логировать или нет 1/0 (на боевом ставим 0)
	protected $startPageLoading=1; // начало логирования страницы 1/0

	public function __construct($name, $file=null, $toLog=0){
		$this->name=$name;
		$this->file=$file;
		$this->toLog=$toLog;
		if($this->toLog){
			$this->open();
	    }
	}

	public function open(){
		if(self::$PATH==null){
			return;
		}
		$this->fp=fopen($this->file==null ? self::$PATH.'/'.$this->name.'.log' : self::$PATH.'/'.$this->file,'a+');
	}

	public static function getLogger($name='root',$file=null, $toLog=0){
		if(!isset(self::$loggers[$name])){
			self::$loggers[$name]=new Logger($name, $file, $toLog);
		}
		return self::$loggers[$name];
	}

	public function log($message){
		if(!$this->toLog) { // если логирование отключено уходим
			return;
		}
		
		if(!is_string($message)){
			$this->logPrint($message);
			return ;
		}

		$log='';
		$log.='['.date('D M d H:i:s Y',time()).'] ';
		if(func_num_args()>1){
			$params=func_get_args();

			$message=call_user_func_array('sprintf',$params);
		}
		$log.=$message;
		$log.="\n";
		if($this->startPageLoading){
			$this->_write("------START LOADING PAGE--------<br/>\r\n");
			$this->startPageLoading = 0;
		}
		$this->_write($log);
	}

	public function logPrint($obj){
		//ob_start();
		//print_r($obj);
		$ob=print_r($obj,true);
		//$ob = array("1"=>"one", "2"=>"two");
		//$ob=ob_get_clean();
		$this->log($ob);
	}

	protected function _write($string){
		fwrite($this->fp, $string);
		//echo $string;
	}

	public function __destruct(){
		if($this->toLog){
			fclose($this->fp);
		}
	}
}

?>