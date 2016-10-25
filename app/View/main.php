<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://www.codingdrama.com/bootstrap-markdown/js/to-markdown.js"></script>
        <script type="text/javascript" src="http://www.codingdrama.com/bootstrap-markdown/js/markdown.js"></script>
        <script type="text/javascript" src="/js/bootstrap-markdown.js"></script>

        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-markdown.min.css">
        <script type="text/javascript">

function executeOnSubmit() {
var res = confirm("Är du säker på att du vill radera bloggen? Du kan inte ändra dig efteråt.");

if(res)
return true;
else
return false;
}

</script>
    </head>
    <body>
        <div class="container">
        <br/>
<?php
      
        if($data->loggedin){?>
        <nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#"></a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/dashboard">Hem</a></li>
        <!-- <li><a href="#"></a></li> -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
       
 <?php
 if($data->auth ==7){?>
    
    
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hantera blogg <b class="caret"></b></a>
          <ul class="dropdown-menu">
            
              
        <li><a href="/<?php echo $data->blogname; ?>/settings">Blogginställningar</a></li>  </ul>
          </li><?php } ?>
        <?php if($data->auth >=6){?>

    
        <li><a href="/<?php echo $data->blogname; ?>/compose">Skriv nytt inlägg</a></li>

              
<?php } ?>
           
           


      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dina bloggar <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <?php  foreach ($data->bloglist as $value) {if ($value->authority >= 6) { ?>
              <li><a href="/<?= $value->url_name ?>"><?= $value->name ?></a></li>
              <?php }} ?>
              
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Annat <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/account/settings">Kontoinställningar</a></li>
              <li><a href="/blog/allFollowers">Visa alla följare</a></li>
              <li><a href="/logout">Logga ut</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <?php
}
?>
            <?php require $view; ?>
        </div>
    </body>
</html>