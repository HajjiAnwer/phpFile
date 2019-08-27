<div class="container-fluid py-3 bg-light">
        <h3 class="text-danger text-center pb-2 font-weight-bold"><em>List of Jokes:</em></h3>
        <div class="container bg-light">
        <hr>
<p>
    <em class="text-capitalize h5 text-justify">
        <?=$totalJokes?> jokes have been submitted to the Internet Joke Database.
    </em>
</p>        
<hr>
<?php 
foreach ($jokes as $joke): ?>
<blockquote>
    <div class="row pb-3 pl-2 pt-2">
        <div class="col-sm-8 h5 text-justify"> 
           <em class="text-capitalize"> <?=htmlspecialchars($joke['joketext'],ENT_QUOTES, 'UTF-8')?></em>
           (by <a href="#">
           <?php echo htmlspecialchars($joke['name'], ENT_QUOTES,'UTF-8'); ?>
               </a>)
               <?php 
               $date = new DateTime($joke['jokedate']);
               echo '<span class="text-danger">'.$date->format('jS F Y').'</span>';
               ?>
            <a href="/joke/edit?idjoke=<?=$joke['idjoke']?>">Edit</a>
        </div>
        <div class="col-sm-4 text-right">      
        <form action="/joke/delete"  method="post">
                <input type="hidden" name="idjoke" value="<?=$joke['idjoke']?>">
                <input type="submit" value="Delete" class="bg-primary  rounded border-primary">
            </form>
        </div>    
    </div>
</blockquote>
<hr>
<?php endforeach; ?>
</div>
</div>