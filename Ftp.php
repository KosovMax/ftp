<?php
	/**
	* Kosovets Maxim 12.02.2016
	* To remote in FTP
	*/
	class ftp{
		public $connect;
		public $login;
		
		/**
		* Connect host of FTP.
		* @param string $conn - host
		*
		*/
		function __construct($conn){
			$this->connect=ftp_connect($conn);
			if(!$this->connect){
				echo "Ftp don't connect";
			}
		}

		/**
		* Out login and password 
		* @param $l - login
		* @param $p - password
		*
		*/
		function login($l, $p){
			$this->login=ftp_login($this->connect, $l, $p);
			if(!$this->login){
				echo "Ftp don't work";
			}
			ftp_pasv($this->connect, true);
		}

		/**
		* Upload file in FTP
		* @param $remote_file - get file form local
		* @param $file - upload file on server FTP
		* @param $format - format file
		*
		*/
		function push_file($remote_file, $file, $format){
			$only=$this->only_format($remote_file ,$format);
			if($only){
				if (ftp_put($this->connect, $remote_file, $file, FTP_ASCII)) {
				 	echo "$file успешно загружен на сервер\n";
				} else {
				 	echo "Не удалось загрузить $file на сервер\n";
				}
			}else{
				echo "Толькo формати jpg, png, gif\n";
			}
		}

		/**
		* Download file form FTP
		* @param $local_file - set file form local
		* @param $server_file - download file form server FTP
		* @param $format - format file
		*
		*/
		function get_file($local_file, $server_file, $format){
			$only=$this->only_format($server_file ,$format);
			if($only){
				if (ftp_get($this->connect, $local_file, $server_file, FTP_BINARY)) {
				    echo "Произведена запись в $local_file\n";
				} else {
				    echo "Не удалось завершить операцию\n";
				}
			}else{
				echo "Толькo формати jpg, png, gif\n";
			}
		}

		/**
		* Only format.
		* @param $ff - to specify file format.
		* @param $f - format file
		*/
		function only_format($ff, $f){
			
			$o_file=explode(".", $ff);
			$arr=explode(",", $f);

			for($i=0; $i<count($arr); $i++){
			 	if(strpos($arr[$i], end($o_file))!==false){
			 		return true;
			 	}
			}

			return false;
		}
		/**
		* Close FTP.
		*/
		function close(){
			ftp_close($this->connect);
		}
	}

?>