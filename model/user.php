<?php

/**
* fg
*/
class user
{	

    /**
     * @label nombre
     * @type text
     * @class miclase
     * @placeholder Username
     */
    public $name;


    /**
     * @type password
     */
    public $password;


    /**
     * @type text
     */
    public $telephone;


    /**
     * @type number
     */
    public $age;


    public function __construct()
    {
        $form = new form($this);
        $this->form = $form;
    }

}

?>