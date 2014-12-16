<ul class="post-list">
  <h2>Frågor</h2>
    <hr />

<input type=hidden name="redirect" value="<?=$this->url->create('')?>">
<div class='comments'>
<?php foreach ($comments as $comment) : ?> 
<div class="post-body">
                    
                   
                    
       						<div class="post-header">
                        
                            <span class="post-name"><a href = "post/id/<?=$comment->id?>"><h3><?=$comment->title?></h3></a></span>
                           
                            <span class="post-menu">
                            <a href='post/delete/<?=$comment->id?>'><input class="deleteButton" type='submit' name='removePost' value='Ta bort'</input></a>   							<a href='post/edit/<?=$comment->id?>'  > <input class="editButton" type='submit' name='doEdit' value='Redigera'</input></a>  								
                            </span>
                             <div class="post-content ">
                      
                    </div>
             
                    
                </div>
            <hr />




<br>

   
                



<?php endforeach; ?>
<br>
</div>