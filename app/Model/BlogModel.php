<?php


class BlogModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function create(string $blogname, string $urlname, bool $nsfw)
  {
    $sqlblog = "INSERT INTO blog(name, url_name) VALUES(?,?)";
    $stmt = $this->prepare($sqlblog);
    $stmt->bind_param("ss", $blogname, $urlname);
    $stmt->execute();
    $current_id = $stmt->insert_id;
    echo $current_id;
    echo '</br>';
    echo 'nsfw: ', $nsfw, ' id=', $current_id;

    if($nsfw) {
      $sqlnsfw = "INSERT INTO blog_tag(blog_id,tag_id) VALUES (?,1)";
      $stmtnsfw = $this->prepare($sqlnsfw);
      $stmtnsfw->bind_param("i", $current_id);
      $stmtnsfw->execute();
    }
  }


}
