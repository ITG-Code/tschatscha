<script>
    function redirect() {
        var query = '';
        if(NULL == document.getElementById("query").value){
            query = document.getElementById("query").value;
        }
        if(query != ""){
            window.location.replace("/home/search/"+ query);
            return false;
        }
    }
</script>
<form action="javascript:redirect()">
    <input type="text" name="query">
    <input type="submit">
</form>

<?php foreach($data->result as $item) { ?>
    <li><a href="/<?=$item->url_name?>"><?=$item->name?></a></li>
<?php } ?>
