
<div class="col-md-12">Ge användare rättigheter till blogg: <?= $data->blogname ?> <a href="/<?= $data->blogname ?>">Tillbaka till <?= $data->blogname ?></a> 
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Ge rättigheter</h3>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" action="/<?= $data->blogname ?>/settings" method="post">
        <div class="form-group">
          <label for="user">Användare</label>
          <input type="text" class="form-control" name="user_id" placeholder="Person">
          <datalist class="">
            <option value="1">Kakan</option>
          </datalist>
        </div>
        <div class="form-group">
          <label for="authority">Rättighetsnivå</label>
          <select class="form-control" name="authority" required="">
            <option value="" selected="" disabled="">Välj</option>
            <option value="<?= Authority::BLOG_CO_WRITER ?>">Delägare</option>
            <option value="<?= Authority::POST_PRIVATE_VIEW ?>">Privata poster</option>
            <option value="<?= Authority::BLOG_MODERATE ?>">Moderator</option>
          </select>
          <p class="help-block">Help text here.</p>
        </div>
        <div class="form-group">
          <input type="submit" class="form-control btn btn-primary" value="Confirm">
        </div>
      </form>
    </div>
  </div>


    <div class="panel panel-primary">
      <div class="panel-heading" href="#removetags" data-toggle="collapse">
        <h3 class="panel-title">Ta bort taggar</h3>
      </div>
      <div class="panel-body collapse" id="removetags">
        <form class="form-horizontal" action="/<?= $data->blogname ?>/updateTags" method="post">
          <fieldset>
            <div class="form-group">
              <label for="tag[]"></label>
              <?php foreach ($data->tags as $value) { ?>
                <input type="checkbox" id="tag[]" class="" name="tag[]" value="<?=$value->tag_id?>">
                <label for="tag[]" class="control-label"><?=$value->name?></label>
                <br/>
                <?php } ?>
                <p class="help-block">Help text here.</p>
              </div>
              <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Ta bort taggar">
              </div>
            </fieldset>
          </form>
        </div>
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading" href="#addtags" data-toggle="collapse">
          <h3 class="panel-title">Lägg till taggar</h3>
        </div>
        <div class="panel-body collapse" id="addtags">
          <form class="form-horizontal" action="/<?= $data->blogname ?>/updateTags" method="post">
            <fieldset>
              <div class="form-group">
                <label for="tags">Taggar</label>
                <input type="text" class="form-control" name="tags" placeholder="Ex. Party, Holiday" id="Tags">
                <p class="help-block">Lista dina tags separerade med ett komma (,)</p>
              </div>
              <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Lägg till taggar">
              </div>
            </fieldset>
          </form>
        </div>
      </div>
      <div class="remove" style="font-size: 30px;">
      <form action="/<?= $data->blogname ?>/settings" method="post" style="font-size: 15px;"><label style="font-size: 26px;">Ta bort blogg</label>
        <input type="hidden" name="delete" value="<?= $data->blogid ?>">
        <input type="submit" name="<?= $data->blogid ?>" value="Ta bort"/>
      </form>
      
      </div>
      
      <div class="left" style="float:left; width:300px;">

    <form method="post" action="/<?= $data->blogname ?>/settings" style="font-size:20px;">
     <label style="font-size:16px;">Sök efter användare</label>
      <input type="text" name="userQuery" placeholder="alias/namn/email" style="font-size:16px;"/>
      <input type="submit" value="Search" style="font-size:16px;"/>

      <div class="searchResult">
      <br/>
        <table align="left" cellspacing="5" cellpadding="8">
          <tr>
            <td align="left"><b>Search result</b></td>
            <td align="left"><b>Email</b></td>
          </tr>
          <?php foreach ($data->usersearch as $value) { ?>
            <tr>
              <td align="left">
                <input type="radio" name="user_id" value="<?=$value->id?>"> <?= $value->name ?>
              </td>
              <td align="left">
                <?= $value->email ?>
              </td>
            </tr>
            <?php } ?>

          </table>
        </div>
        </div>
      <div class="right" style="float:right; width:300px;">
      <label> Co-writer</label>
      <input type="radio" name="authority" value="<?= Authority::BLOG_CO_WRITER ?>"/></br>
      <label> Private view </label>
      <input type="radio" name="authority" value="<?= Authority::POST_PRIVATE_VIEW ?>"/></br>
      <label> Moderate </label>
      <input type="radio" name="authority" value="<?= Authority::BLOG_MODERATE ?>"/></br>
      <input type="submit" value="Confirm" style="font-size:14px;"/>
      </div>
      </form>
      
     

    




    