<div>
  

<h2 style = "float:left;"><?=$question->title?></h2> <p style = "float:right;"><a href="<?=$this->url->create('users/id/' . $question->user)?>"><?=$question->user?></a> <?=$question->created?></p>


<div style = "clear:both;">
</div>
<?php foreach ($tags as $tag) { ?>
<a style="text-decoration:none;" href="<?=$this->url->create('questions/list/' . $tag->tag)?>"><?=$tag->tag?></a>
<? } ?>
<p style="margin-top:10px;"><?=$question->content?></p>

<?php foreach ($comments as $comment) { ?>
<div style="margin-bottom:5px;">
	<span><?=$comment->content?> - </span><span> kommenterat av <a href="<?=$this->url->create('users/id/' . $comment->user)?>"><?=$comment->user?></a></span> <span style="font-style:italic;"><?=$comment->created?></span>
</div>


<? } ?>
<?php if(isset($_SESSION['user']))  
        {  ?>
<form action="<?=$this->url->create('questions/addComment/')?>" method="POST">
	<br>
<input type="text" name="content"> 
<input type="hidden" name="linkid" value="<?=$question->id?>">
<input type="hidden" name="redirect" value="<?=$question->id?>">
<input type="hidden" name="comment" value="question">
<input type="hidden" name="user" value="<?=$_SESSION['user']?>">
<input type="hidden" name="type" value="Kommentar">
<input type="submit" value="Kommentera">
<br><br>
</form>
</div>
<? } ?>
<hr />
<?php foreach($answers as $answer) { ?>
<div>

<p style=""><?=$answer['content']?></p>
<span style="font-style:italic;">Besvarad av <a href="<?=$this->url->create('users/id/' . $answer['user'])?>"><?=$answer['user']?></a></span><span style="font-style:italic;"> <?=$answer['created']?></span>


<?php foreach($answer['comments'] as $comment) {?>

<div style="margin-top:5px;">
	<span><?=$comment->content?> - </span><span> kommenterat av <a href="<?=$this->url->create('users/id/' . $comment->user)?>"><?=$comment->user?></a></span> <span style="font-style:italic;"><?=$comment->created?></span>
</div>



<?php }?>
<?php if(isset($_SESSION['user']))  
        {  ?>
<form action="<?=$this->url->create('questions/addComment/')?>" method="POST">
	<br>
<input type="text" name="content"> 
<input type="hidden" name="linkid" value="<?=$answer['id']?>">
<input type="hidden" name="redirect" value="<?=$question->id?>">
<input type="hidden" name="comment" value="answer">
<input type="hidden" name="user" value="<?=$_SESSION['user']?>">
<input type="hidden" name="type" value="Kommentar">
<input type="submit" value="Kommentera">
<br><br>
</form>
<?php }?>
<hr />
</div>
<?php }?>

<?php if(isset($_SESSION['user']))  
        {  ?>

<div style="margin-top:20px;min-width:100%;"><h3 style="margin-bottom:0px;">Besvara denna fråga</h3><?=$form?></div><?php } else print "<p style = 'margin-top:50px;'>För att lämna en kommentar så måste du <a href = 'http://localhost:9000/phpmvc/kmom07:10/naess/webroot/profile'> Logga in</a></p>";  ?>
