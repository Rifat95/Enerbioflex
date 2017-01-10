<?php foreach($users as $user): ?>
	<p class="centre">
		   <a href="user.php?id=<?= $user['id'] ?>"><?= $user['login'] ?></a>
	</p>
<?php endforeach; ?>
