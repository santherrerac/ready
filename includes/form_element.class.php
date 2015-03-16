<?php 

/**
*  
*/
class form_element
{
    public $label;
    
    function __construct()
    {
        # code...
    }

    public function label()
    {
        if(isset($this->label)) return "<label>$this->label</label>";
    }



    public function render()
    {
        print $this->label();
        print $this->start_tag();
    }
    

    public function start_tag()
    {
        $attrs     = $this->attrs();
        $start_tag = "<input$attrs>";

        return $start_tag;
    }


    public function attrs()
    {
        $attrs = get_object_vars($this);
        $tag   = "";
        
        unset($attrs['label']);       

        foreach ($attrs as $key => $value) 
        {
            $tag.= " $key = \"$value\"";
        }

        return $tag;
    }

}

 ?>