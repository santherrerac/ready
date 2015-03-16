<?php

class html_tag
{
    private $tag_name;
    private $html;


    public function __construct($tag_name)
    {
        $this->tag_name = $tag_name;
    }


    public function render()
    {
        print $this->start_tag();
        
        if($this->tag_name == "input") return;
        
        print $this->html();
        print $this->end_tag();
    }
    

    public function start_tag()
    {
        $attrs     = $this->attrs();
        $start_tag = "<$this->tag_name$attrs>";

        return $start_tag;
    }


    public function attrs()
    {
        $attrs = get_object_vars($this);
        $tag   = "";

        unset($attrs['tag_name']);
        unset($attrs['html']);

        foreach ($attrs as $key => $value) 
        {
            $tag.= " $key = \"$value\"";
        }

        return $tag;
    }


    public function html()
    {
        return $this->html;
    }


    public function end_tag()
    {
        $end_tag = "</$this->tag_name>";        

        return $end_tag;
    }
    
}

?>