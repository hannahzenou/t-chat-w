<?php
	
	$w_routes = array(
		// Quand on essaie d'accéder à localhost/t-chat/public/
		// L'url réélement reçu est : localhost/t-chat/index.php/
		['GET', '/', 'Default#home', 'default_home'], // La route est accessible uniquement par GET à l'url racine du site / , Defaut : controller, home : methode, nom de cette route default_home
		['GET', '/test', 'Test#monAction', 'test_index'],
		['GET', '/users', 'User#listUsers', 'users_list'],
		['GET|POST', '/salon/[i:id]', 'Salon#seeSalon', 'see_salon'], // [i:id] i pour vérifier que c'est un int et :id correspond au paramètre $id de la fonction
		['GET|POST', '/login', 'User#login', 'login'],
		['GET', '/logout', 'User#logout', 'logout']
	);