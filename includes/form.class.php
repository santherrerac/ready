<?php

class form
{
    public $model;
    public $elements = array();


    public function __construct($model = null)
    {
        if($model)
        {
            $this->model = $model;
            $this->construct_model_form();
        }        
    }


    public function render()
    {
        foreach ($this->elements as $name => $element) 
        {
            $element->render();
            print "<br>";
        }        
    }


    public function construct_model_form()
    {    
        global $post;
        $properties = get_object_vars($this->model);
 
        foreach ($properties as $property_name => $value) 
        {
            $input       = new form_element();
            $input->id   = get_class($this->model)."[$property_name]";        
            $input->name = get_class($this->model)."[$property_name]";

            if(isset($post->{get_class($this->model)}))
            {
                $input->value = $post->{get_class($this->model)}[$property_name]; 
            }                   

            $annotations = annotations::get_property_annotations($this->model, $property_name);

            foreach ($annotations as $name => $value) 
            {
                $input->{$name} = $value;
            }
            
            if(!isset($input->label)) $input->label = $property_name;

            $this->{$property_name} = $input;
            $this->elements[$property_name] =$input;
        }
    }
    
}

?>