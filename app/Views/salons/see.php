<?php $this->layout('layout', ['title' => 'Messages de mon salon']) ?>

<?php $this->start('main_content'); ?>

<h2>Bienvenue sur le salon "<?php echo $this->e($salon['nom']); ?>"</h2> <!--e est un équivalent htmlentities du framework-->

<ol class="messages">

	<?php foreach ($messages as $message) : ?> 
		<li>
		<span class="personne"><?php echo $this->e($message['pseudo']); ?> : </span>
		<span class="message">"<?php echo $this->e($message['corps']); ?>"</span></li> 
	<?php endforeach ; ?>

</ol>

<!-- $this->url('see_salon'), array('id'=>$salon['id']) va générer une url du genre : t-chat-w/public/$salon/['id']-->
<form class="form-message" action="<?php $this->url('see_salon', array('id'=>$salon['id']))?>" method="POST">
	<p>
		<input type="text" name="corps"></input> <input class="button" name="send" type="submit" value="Envoyer">

	</p>
</form>

<?php $this->stop('main_content'); ?>