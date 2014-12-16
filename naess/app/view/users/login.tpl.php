<h1><?=$title?></h1>

<?=$content?>

<?php if($message == 'success') : ?>
<span>Du har skapat en användare, varsågod att logga in.</span>
<?php else : ?>
<span><a href="create">Skapa ny användare</a></span>	
<?php endif ; ?>

<?php if (isset($links)) : ?>
<ul>
<?php foreach ($links as $link) : ?>
<li><a href="<?=$link['href']?>"><?=$link['text']?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>