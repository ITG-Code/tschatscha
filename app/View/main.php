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
            <?php require $view; ?>
        </div>
    </body>
</html>