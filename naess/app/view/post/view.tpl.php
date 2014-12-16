<div>
<h2 style = "float:left;"><?=$question->title?></h2>
<p style = "float:right;"><a href="<?=$this->url->create('users/id/' . $question->user)?>"><?=$question->user?></a> <?=$question->created?></p>

<div style = "clear:both;">
</div>

<p style="margin-top:10px; margin-bottom:30px;"><?=$question->content?></p>
<span style="margin-bottom:0px; font-size:20px;">Taggar:</span>
<?php foreach ($tags as $tag) { ?>
<span style="margin-bottom:0px; font-size:20px;"><a style="text-decoration:none;" href="<?=$this->url->create('questions/list/' . $tag->tag)?>"><?=$tag->tag?></a></span>
<? } ?>

<hr style="border-top: dashed 1px lightgrey; margin-top:20px;" />

<?php foreach ($comments as $comment) { ?>
<div style="margin-bottom:5px; float:right;">
	<span><?=$comment->content?> - </span><span><a href="<?=$this->url->create('users/id/' . $comment->user)?>"><?=$comment->user?></a></span> <span style="font-style:italic;"><?=$comment->created?></span>
</div>
<div style = "clear:both;">
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
<input type="hidden" name="questionid" value="<?=$question->id?>">
<input type="submit" value="Kommentera">

</form>
</div>
<? } ?>

<h2>Svar</h2>

<?php foreach($answers as $answer) { ?>
<hr />
<div style = "min-height:150px; margin-bottom:50px;">

<p style="float:left;"><?=$answer['content']?></p>
<p style="font-style:italic; float:right;"><a href="<?=$this->url->create('users/id/' . $answer['user'])?>"><?=$answer['user']?></a> <?=$answer['created']?></p>
<div style = "clear:both;">
</div>

<hr style="border-top: dashed 1px lightgrey;" />
<?php foreach($answer['comments'] as $comment) {?>

<div style="margin-top:5px; float:right;">
	<span><?=$comment->content?> - </span><span><a href="<?=$this->url->create('users/id/' . $comment->user)?>"><?=$comment->user?></a></span> <span style="font-style:italic;"><?=$comment->created?></span>
</div>



<?php }?>

<?php if(isset($_SESSION['user']))  
        {  ?>
<form action="<?=$this->url->create('questions/addComment/')?>" method="POST">

    
<input type="text" name="content"> 
<input type="hidden" name="linkid" value="<?=$answer['id']?>">
<input type="hidden" name="redirect" value="<?=$question->id?>">
<input type="hidden" name="comment" value="answer">
<input type="hidden" name="user" value="<?=$_SESSION['user']?>">
<input type="hidden" name="type" value="Kommentar">
<input type="hidden" name="questionid" value="<?=$question->id?>">
<input type="submit" value="Kommentera">

</form>
<?php }?>

</div>
<?php }?>

<?php if(isset($_SESSION['user']))  
        {  ?>

<div ><h3 >Lämna ett svar</h3><?=$form?></div><?php } else print "<p style = 'margin-top:50px;'>För att lämna ett svar så måste du <a href = 'http://localhost:9000/phpmvc/kmom07:10/naess/webroot/profile'> Logga in</a></p>";  ?>
