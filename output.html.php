

    <div class="container-fluid py-3 bg-light">
        <h3 class="text-danger text-center pb-2 font-weight-bold"><em>List of Jokes:</em></h3>
        <div class="container bg-light">
        <hr>
        
<?php 
foreach ($jokes as $joke): ?>
<blockquote>
    <div class="row pb-3 pl-2 pt-2">
        <div class="col-sm-8 h5 text-justify"> 
           <em class="text-capitalize"> <?=htmlspecialchars($joke['joketext'],ENT_QUOTES, 'UTF-8')?></em>
           
           (by <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES,'UTF-8'); ?>">
           <?php echo htmlspecialchars($joke['name'], ENT_QUOTES,'UTF-8'); ?>
               </a>)
            <a href="/joke/edit?idjoke=<?=$joke['idjoke']?>">Edit</a>   
            <i class="fas fa-smile" style="font-size:30px;color:yellow;text-shadow:2px 2px 4px #000000;"></i>
            <i class="fas fa-smile" style="font-size:30px;color:yellow;text-shadow:2px 2px 4px #000000;"></i>
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