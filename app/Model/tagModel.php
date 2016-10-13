<?php  

class TagModel extends Model
{
    public function __construct()

    {
        parent::__construct();
    }
    public function checkTag($tags)
    {
        $tag = explode(" ", $tags);
        $stmt = self::prepare("SELECT id FROM tag WHERE name = ?");
        for ($i = 0; $i < sizeof($tag); $i++) { 
            $stmt->bind_param('s',$tag[$i]);      
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $id = $result->fetch_object()->id;
                self::linkTag($tag[$i], $id);
            } else {
                self::addTag($tag[$i]);
            }
        }     
    }
    //
    public function linkTag($tag, $id)
    {
        echo "hello";
    }

    public function addTag($tag)
    {
        echo "hello";
    }
}