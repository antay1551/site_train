<?php

	echo"33333333333333";

	echo"11111111111111111111111";
	    $routs = explode('/', $_SERVER['REQUEST_URI']); // Разделяем наш запрос
		print_r( $routs );
		$uri = $_SERVER['REQUEST_URI'];
		$uriexplode = explode('/', $uri);
		$controller = $uriexplode[2];
		$uri = str_replace('/mvc4/' . $controller . '/','',$uri);
		include 'Model.php';
		include $controller . '.php';//можно использовать require 'Controller.php'
		$c = new $controller;
		if($uri == ""){
			$uri = 'login';
		}
		if(!method_exists($c, $uri))//проверяем есть ли метод в контроллере
		{
			$uri = 'error404'; // можно записать $c -> error404();
		}
		$c->$uri($uriexplode[4]);
		
		//header('Location: http://localhost:8888/poezd/view/1.html');
   
   
   
   
   function get_routs () 
	     {

    	 $action = $this->funcs_prefix . $this->action;	// Получаем название функции  
		 if(method_exists($this, $action)) $this->$action(); // Если функция присутствует, то выполняем
	     else die('Возникла ошибка, ваш запрос не верен!'); 

				     
		 }
	 

?>