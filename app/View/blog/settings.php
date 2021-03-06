
<div class="col-md-12"> 
  <div class="panel panel-primary">
        <div class="panel-heading" href="#giverights" data-toggle="collapse" style="cursor: pointer;">
          <h3 class="panel-title">Ge användare rättigheter till <span style="text-transform: capitalize; font-style: bold;"><?= $data->realBlogName->name?></span></h3>
        </div>
        <div class="panel-body collapse" id="giverights">
    <div class="panel-body" class="panel-body collapse" id="giverights">
      <form class="form-horizontall" action="/<?= $data->blogname ?>/settings" method="post">
        <div class="form-group">
          <div class="left">

          <form method="post" action="/<?= $data->blogname ?>/settings" style="font-size:20px;">
           <label>Sök efter användare</label>
            <input type="text" name="userQuery" placeholder="alias/namn/email" style="font-size:16px;"/>
            <input type="submit" class="form-control btn btn-primary" style="width:100px;" value="Sök" style="font-size:16px;"/>
          </form>
          <form method="post" action="/<?= $data->blogname ?>/settings" style="font-size:20px;">
            <div class="searchResult">
              <table>
               <tr>
                <td class="searchname">Namn</td>
                <td class="searchemail">Email</td>
               </tr>
          <?php foreach ($data->usersearch as $value) { ?>
               <tr class="spacer">
                <td align="left"  class="spacer">
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
        </div>
      </div>
        <div class="right">
         <label for="authority">Rättighetsnivå</label>
          <select class="form-control" name="authority" required="">
            <option name="authority" value="" selected="" disabled="">Välj</option>
            <option name="authority" value="<?= Authority::BLOG_CO_WRITER ?>">Delägare</option>
            <option name="authority" value="<?= Authority::POST_PRIVATE_VIEW ?>">Privata poster</option>
            <option name="authority" value="<?= Authority::BLOG_MODERATE ?>">Moderator</option>
          </select>
          <p class="help-block">Help text here.</p>
        </div>
        <div class="form-group">
          <input type="submit" class="form-control btn btn-primary" value="Bekräfta">
        </div>
      </form>
  
  </div>
</div>

          
         
<div class="panel panel-primary">
        <div class="panel-heading" href="#removerights" data-toggle="collapse" style="cursor: pointer;">
          <h3 class="panel-title">Ta bort rättigheter från användare</h3>
        </div>
        <div class="panel-body collapse" id="removerights">
          <form method="post" action="/<?= $data->blogname ?>/settings">
            <fieldset>
              <div class="form-group">
              <div class="left">
                <label for="user">Användare</label><br/>
                <?php
                foreach ($data->userID as $value) {?>
                      <input type="radio" name="removerights" value="<?= $value->user_id ?>"/>
                        <?= $value->alias ?><br/>
                        <?php                                                                                                                                                                                                                                                                                                                                                                                                                                     }
                        ?>
                      </div>
                      <div class="right">
                        <label for="right">Rank</label><br/>
                                <?php
                                foreach ($data->userID as $value) {?>
                                        <?php
                                        switch ($value->authority) {
                                            case Authority::BLOG_OWNER:
                                                $authorityName = "Ägare";
                                                break;
                                            case Authority::BLOG_CO_WRITER:
                                                $authorityName = "Delägare";
                                                break;
                                            case Authority::BLOG_MODERATE:
                                                $authorityName = "Moderator";
                                                break;
                                            default:
                                                $authorityName = "Privata poster";
                                        }
                                    ?>
                                                <?= $authorityName ?><br/>
                      
                                <?php                                                   }
                    ?>
                    </div>

        </div><br/>
   <input type="submit" class="form-control btn btn-primary" value="Bekräfta">
   
            </fieldset>
          </form>
        </div>
      </div>

    <div class="panel panel-primary">
      <div class="panel-heading" href="#removetags" data-toggle="collapse" style="cursor: pointer;">
        <h3 class="panel-title">Ta bort taggar</h3>
      </div>
      <div class="panel-body collapse" id="removetags">
        <form class="form-horizontal" action="/<?= $data->blogname ?>/updateTags" method="post">
          <div class="form-group">

            
              <label for="tag[]"></label>
                <?php foreach ($data->tags as $value) { ?>
                <input type="checkbox" id="tag[]" class="" name="tag[]" value="<?=$value->tag_id?>">
                <label for="tag[]" class="control-label"><?=$value->name?></label>
                <br/>
                <?php } ?>
                <p class="help-block">Markera alla taggar du vill ta bort</p>
              </div>
              <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Ta bort taggar">
              </div>
            
          </form>
        </div>
      </div>

      <div class="panel panel-primary">
        <div class="panel-heading" href="#addtags" data-toggle="collapse" style="cursor: pointer;">
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
      <div class="panel panel-default">
    <div class="panel-heading" style="cursor: pointer;">
      <h3 class="panel-title" href="#deleteblog" data-toggle="collapse">Ta bort bloggen</h3>
    </div>
    <div class="panel-body collapse" id="deleteblog">
      <form class="form-horizontal" action="/<?= $data->blogname ?>/settings" method="post">
        <fieldset>
          <div class="form-group">
            <label for="blog">Ta bort blog</label>
             <input type="hidden" name="delete" value="<?= $data->blogid ?>">
        <input type="hidden" name="<?= $data->blogid ?>" value="delete"/>
          </div>
          <div class="form-group">
            <label for="confirmpassword">Lösenord</label>
            <input type="password" class="form-control" name="confirmpassword" placeholder=""/>
            <p class="help-block">Verifiera med ditt lösenord</p>
          </div>
          <div class="form-group">
            <input type="submit" name="<?= $data->blogid ?>" class="form-control btn btn-primary" value="Ta bort" onClick='return executeOnSubmit();'>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

     <!--  <form action="/<?= $data->blogname ?>/settings" method="post" style="font-size: 15px;"><label style="font-size: 26px;">Ta bort blogg</label>
        <input type="hidden" name="delete" value="<?= $data->blogid ?>">
        <input type="submit" name="<?= $data->blogid ?>" value="Ta bort"/>
      </form>
      
       -->
      
<!--       <div class="left">

    <form method="post" action="/<?= $data->blogname ?>/settings" style="font-size:20px;">
     <label style="font-size:16px;">Sök efter användare</label>
      <input type="text" name="userQuery" placeholder="alias/namn/email" style="font-size:16px;"/>
      <input type="submit" value="Search" style="font-size:16px;"/>
    </form>
    <form method="post" action="/<?= $data->blogname ?>/settings" style="font-size:20px;">
      <div class="searchResult">
      <br/>
        <table>
          <tr>
            <td><b>Search result</b></td>
            <td><b>Email</b></td>
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
      <div class="right">
      <!-- <label> Co-writer</label>
      <input type="radio" name="authority" value="<?= Authority::BLOG_CO_WRITER ?>"/></br>
      <label> Private view </label>
      <input type="radio" name="authority" value="<?= Authority::POST_PRIVATE_VIEW ?>"/></br>
      <label> Moderate </label>
      <input type="radio" name="authority" value="<?= Authority::BLOG_MODERATE ?>"/></br> -->
     
   <!--    <label for="authority">Rättighetsnivå</label>
          <select class="form-control" name="authority" required="">
            <option name="authority" value="" selected="" disabled="">Välj</option>
            <option name="authority" value="<?= Authority::BLOG_CO_WRITER ?>">Delägare</option>
            <option name="authority" value="<?= Authority::POST_PRIVATE_VIEW ?>">Privata poster</option>
            <option name="authority" value="<?= Authority::BLOG_MODERATE ?>">Moderator</option>
          </select>
      <input type="submit" value="Bekräfta" style="font-size:14px;"/>
      </div>
      </form>
      
     

     -->
 



    
