<h1><?=$title?> <span style="font-size:20px;"> <a href='<?=$this->url->create('questions/add')?>'>Ställ fråga</a></span></h1>
<?php if (is_array($questions) && !empty($questions)) : ?>  

<div class="questions"> 
	<?php $color=0; ?> 
<?php foreach ($questions as $question) : ?>  

<?php $url = $this->url->create('questions/show') .'/' . $question->id?>

<a href=<?php echo $url?>><div class="question"  style='overflow:auto; padding:10px; padding-bottom:10px;<?php if (($color % 2) == 0) {echo "background-color: lightgrey;";} else {echo "background-color: white;";} ?>position:relative;'>
<?php $color++; ?>

<h4 style="clear:both;"><span class='questionName'><?=$question->title?></span></h4>



	 <span style="float:right;"><?=$question->created?></span> 
</div></a>
<?php endforeach;?> 
</div>  
<?php endif; ?> 