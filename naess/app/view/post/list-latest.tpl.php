<h2><?=$title?></h2>
<hr />
<?php if (is_array($questions) && !empty($questions)) : ?>  
<div class="questions"> 
	
<?php foreach ($questions as $question) : ?>  

<?php $url = $this->url->create('questions/view') .'/' . $question->id?>

<a href=<?php echo $url?>><div class="question">


<h4 style="clear:both;"><span class='questionName' style = "float:left"><?=$question->title?></span></h4>



	 <span style="float:right;"><?=$question->created?></span> <br />
</div></a>
<?php endforeach;?> 
</div>  
<?php endif; ?> 