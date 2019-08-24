<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" 
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
     crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title><?php $title ?></title>
</head>
<body>
    <div class="container-fluid m-0">
        <div>
            <div class="container-fluid bg-success p-5">
               <p class="text-white h1"><i class="fas fa-cat" style="font-size:60px;color:#dcdcdc;text-shadow:2px 2px 4px #000000;"></i> Internet Joke Database</p>
            </div>
</div>
        <nav class="nav bg-dark m-0"  >
           <div class="container-fluid">
                <ul class="list-unstyled py-2">
                <div class="row">
                    <div class="col-sm-4 text-center py-2">
                   <li><a href="/" class="text-white">Home</a></li>
                   </div>
                   <div class="col-sm-4 text-center py-2">
                   <li><a href="/joke/list" class="text-white">Joke List</a></li>
                   </div>
                   <div class="col-sm-4 text-center py-2">
                   <li><a href="/joke/edit" class="text-white">Add A New Joke</a></li>
                   </div>
                </div>
            </ul>
           </div>
        </nav>
        <main>
            <?php echo $output ?>
        </main>
        
    