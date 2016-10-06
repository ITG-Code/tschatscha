<?php


class BlogModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function createBlog($blogname,$urlname)
  {
    $sql = "INSERT INTO blog(name, url_name) VALUES(?,?)";
    $stmt = $this->prepare($sql);
    $stmt->bind_param("ss",$blogname,$urlname);
    $stmt->execute();
  }


}
