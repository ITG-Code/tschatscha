<?php


class BlogModel extends Model
{
  public function createBlog($blogname,$urlname,$sql)
  {
    $stmt = $this->prepare($sql);
    $stmt->bind_param("ss",$blogname,$urlname);
    $stmt->execute();
  }


}
