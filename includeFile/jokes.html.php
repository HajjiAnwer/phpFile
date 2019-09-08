<div class="container-fluid py-3 bg-light">
        <h3 class="text-danger text-center pb-2 font-weight-bold"><em>List of Jokes:</em></h3>
        <div class="container bg-light">
        <hr>
<ul>
    <?php foreach ($categories as $category): ?>
        <li><a href="/joke/list?category=<?=$category->id?>"><?=$category->categoryname?></a></li>
    <?php endforeach; ?>
</ul>
<p>
    <em class="text-capitalize h5 text-justify">
        <?=$totalJokes?> jokes have been submitted to the Internet Joke Database.
    </em>
</p>        
<hr>
<?php 
foreach ($jokes as $joke):
?>
<blockquote>
    <div class="row pb-3 pl-2 pt-2">
        <div class="col-sm-8 h5 text-justify"> 
           <?php $markdown = new Markdown($joke->joketext);echo $markdown->toHtml();?>
           (by <a href="#">
           <?php echo htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES,'UTF-8'); ?>
               </a>)
               <?php 
               $date = new DateTime($joke->jokedate);
               echo '<span class="text-danger">'.$date->format('jS F Y').'</span>';
               ?>
            <?php if ($user): ?>
            <?php if ($user->id == $joke->authorid ||
            $user->hasPermission(Author::EDIT_JOKES)): ?>
            <a href="/joke/edit?idjoke=<?=$joke->idjoke?>">Edit</a>
            <?php endif; ?>
        </div>
        <div class="col-sm-4 text-right">    
        <?php if ($user->id == $joke->authorid ||
        $user->hasPermission(Author::DELETE_JOKES)):?>  
            <form action="/joke/delete"  method="post">
                <input type="hidden" name="idjoke" value="<?=$joke->idjoke?>">
                <input type="submit" value="Delete" class="bg-primary  rounded border-primary">
            </form>
        </div>
        <?php endif; ?>
        <?php endif; ?>    
    </div>
</blockquote>
<hr>
<?php endforeach; ?>
Select page:
<?php
$numPages = ceil($totalJokes/3);
for ($i = 1; $i <= $numPages; $i++):
if ($i == $currentPage):?>
<a class="text-danger"href="/joke/list?page=<?=$i?>
<?=!empty($categoryid) ?'&category=' . $categoryid : '' ?>"><?=$i?></a>
<?php else: ?>
<a href="/joke/list?page=<?=$i?>
<?=!empty($categoryid) ?'&category=' . $categoryid : '' ?>"><?=$i?></a>
<?php endif; ?>
<?php endfor; ?>
</div>
</div>