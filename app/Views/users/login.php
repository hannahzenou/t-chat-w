<?php $this->layout('layout', ['title' => 'Connectez-vous !']); ?>


<?php $this->start('main_content'); ?>

<h2>Connectez-vous à T'Chat</h2>

<form action="<?php $this->url('login')?>" method="POST">
	<p>
		<label for="pseudo">Pseudo :</label>
		<input type="text" name="pseudo" id="pseudo" value="<?php echo isset($datas['pseudo']) ? $datas['pseudo'] : '' ; ?>"> <!--on vérifie qu'il y a eu un POST pseudo et on le garde dans le form que l'utilisateur n'a pas réussi à se connecter comme ça pas besoin de tous remplir encore-->
	</p>

	<p>
		<label for="mot_de_passe">Mot de passe :</label>
		<input type="password" name="mot_de_passe" id="mot_de_passe">
	</p>

	<p>
		<input type="submit" class="button" value="Me connecter">
		<a class="button" href="#" title="Accéder à la page d'inscription">Pas encore inscrit ?</a>
	</p>
</form>

<?php $this->stop('main_content'); ?>