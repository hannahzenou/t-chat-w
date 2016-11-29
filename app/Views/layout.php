<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title><?php echo $this->e($title); ?></title>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<!-- $this->assetUrl('css/reset.css') vaudra 'assets/css/reset.css'-->
		<link rel="stylesheet" href="<?php echo $this->assetUrl('css/reset.css') ?>" type="text/css"> 
		<link rel="stylesheet" href="<?php echo $this->assetUrl('css/style.css') ?>" type="text/css">
	</head>

	<body>
		<header>
			<h1><?php echo $this->e($title); ?></h1>
		</header>

		<aside> 
			<h3><a href="<?php echo $this->url('default_home'); 
			//url prend en paramètre le nom de la route afin de rediriger vers la bonne page et en deuxieme les paramètre qu'on voudrait passer en GET
			?>" title="Revenir à l'accueil">Les salons</a></h3>

			<nav>
				<ul id="menu-salons">

				<?php foreach($salons as $salon) : ?>

				<li><a href="<?php echo $this->url('see_salon', array('id'=>$salon['id']))?>"><?php echo $this->e($salon['nom']) ; ?> </a></li>

				<?php endforeach ; ?>


					<li>
						<a class="button" href="<?php echo $this->url('users_list')?>" title="Liste des utilisateurs">Liste des utilisateurs</a>
					</li>
					<li>
						<a class="button" href="<?php echo $this->url('logout'); ?>" title="Se déconnecter de T'Chat">Déconnexion</a>
					</li>
				</ul>
			</nav>
		</aside><main>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		</main>

		<footer>
		</footer>
	</body>
</html>