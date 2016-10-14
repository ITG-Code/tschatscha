<?php

class TagModel extends Model
{
    public function __construct()

    {
        parent::__construct();
    }
    // param 2 -> true for post, false for blog
    public function checkTag(string $tags,bool $post,int $id, string $blogName)
    {
        //TODO check tag and tags length lowertags
        if (sizeof($tags) > 255) {
            UserError::add(Lang::FORM_TAGS_EXCEED_CHAR_LIMIT);
            Redirect::to('/'.$blogName.'/compose');
        }
        $tag = array_filter(explode(",", $tags), 'strlen');
        $stmt = self::prepare("SELECT id FROM tag WHERE name = ?");
        for ($i = 0; $i < sizeof($tag); $i++) {
            $tag[$i] = trim($tag[$i]);
            if (sizeof($tag[$i]) > 30) {
                UserError::add(Lang::FORM_TAG_EXCEED_CHAR_LIMIT);
                if ($post) {
                    Redirect::to('/'.$blogName.'/compose');
                } else {
                    Redirect::to('/dashboard');
                }
            }
            $tag[$i] = strtolower($tag[$i]);
            $stmt->bind_param('s',$tag[$i]);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tag_id = $result->fetch_object()->id;
                if ($post) {
                    self::linkTagPost($id,$tag_id);
                } else {
                     self::linkTagBlog($id,$tag_id);
                }
            } else {
                self::addTag($tag[$i],$post, $id);
            }
        }
    }
    public function linkTagPost($id, $tag_id)
    {
        if (self::uniqueLink(true, $id, $tag_id)) {
            $stmt = self::prepare("INSERT INTO  post_tag (post_id , tag_id ) VALUES (?,?)");
            $stmt->bind_param('ii',$id, $tag_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function linkTagBlog($id, $tag_id)
    {
        if (self::uniqueLink(false, $id, $tag_id)) {
            $stmt = self::prepare("INSERT INTO  blog_tag (blog_id , tag_id ) VALUES (?,?)");
            $stmt->bind_param('ii',$id, $tag_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function deleteTagPost($id, $tag_id)
    {
            $stmt = self::prepare("DELETE FROM post_tag WHERE post_id = ? AND tag_id = ?");
            $stmt->bind_param('ii',$id, $tag_id);
            $stmt->execute();
            $stmt->close();
    }

    public function deleteTagBlog($id, $tag_id)
    {
            $stmt = self::prepare("DELETE FROM blog_tag WHERE blog_id = ? AND tag_id = ?");
            $stmt->bind_param('ii',$id, $tag_id);
            $stmt->execute();
            $stmt->close();
    }


    public function uniqueLink($post, $id, $tag_id)
    {
        if ($post) {
            $stmt = self::prepare("SELECT  id  FROM  post_tag  WHERE post_id = ? AND tag_id = ?");
        } else {
            $stmt = self::prepare("SELECT  id  FROM  blog_tag  WHERE blog_id = ? AND tag_id = ?");
        }
        $stmt->bind_param('ii', $id, $tag_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function addTag($tag, $post, $id)
    {
        $date = date('Y-m-d H:i:s');
        $stmt = self::prepare("INSERT INTO  tag (name , created_at ) VALUES (?,?)");
        $stmt->bind_param('ss',$tag, $date);
        $stmt->execute();
        $tag_id = $stmt->insert_id;
        $stmt->close();

        if ($post) {
            self::linkTagPost($id,$tag_id);
        } else {
            self::linkTagBlog($id,$tag_id);
        }
    }

    public function changeTags(int $blog_id)
    {
        $string = "";
        $stmt = self::prepare("SELECT blog_tag.tag_id, tag.name FROM blog_tag INNER JOIN tag ON blog_tag.tag_id = tag.id WHERE blog_tag.blog_id = ?");
        $stmt->bind_param('i', $blog_id);
        $stmt->execute();
        $result= $stmt->get_result();
        if ($result->num_rows > 0) {
/*            while ($row = $result->fetch_object()) {
                $string .= '<tr>
                                <td>
                                    <label for="checkTag">'.$row->name.' </label>
                                </td>
                                <td>
                                    <input type="checkbox" name="checkTag" id="checkTag" value="'.$row->tag_id.'">
                                </td>
                            </tr>';
            }
        }
        $string .= '<tr>
                        <td>
                            <label for="Tags">Tags: </label>
                        </td>
                        <td>
                            <input type="text" name="Tags" placeholder="Ex. Party Holiday" id="Tags" required="">
                        </td>
                    </tr>';
        return $string;
*/
        $retval = [];
        while($row = $result->fetch_object()){
            $retval[] = $row;
        }
        return $retval;
    }
    }
}       