<ul class="post-list">
  <h2>Kommentarer</h2>
    <hr />

<input type=hidden name="redirect" value="<?=$this->url->create('')?>">
<div class='comments'>
<?php foreach ($comments as $comment) : ?> 
<div class="post-body">
                    
                   
                    
       						<div class="post-header">
                        
                            <span class="post-name"><h3><?=$comment->name?></span>
                            <span class="post-id"> | Kommentar #<?=$comment->id?></h3></span>
                            <span class="post-menu">
                            <a href='comment/delete/<?=$comment->id?>'><input class="deleteButton" type='submit' name='removePost' value='Ta bort'</input></a>   							<a href='comment/edit/<?=$comment->id?>'  > <input class="editButton" type='submit' name='doEdit' value='Redigera'</input></a>  								
                            </span>
                             <div class="post-content ">
                        <?= $comment->content ?>
                    </div>
                    
                    <div class="post-footer">
                        <p>Hemsida: <a href = <?=$comment->homepage?>'><?=$comment->homepage?></a></p><p> Mail: <?=$comment->email?> </p>
                    </div>
                    
                </div>
            <hr />




<br>

   
                



<?php endforeach; ?>
<br>
</div>