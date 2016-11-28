<?php $this->layout('layout', ['title' => 'Liste des utilisateurs']) ?>

<?php $this->start('main_content');?>
<ul>
	<?php foreach ($listUsers as $user) : ?>

	<li><?php echo $user['pseudo'] ?></li>

	<?php endforeach; ?>
</ul>
<?php $this->stop('main_content');?>