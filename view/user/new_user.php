<?php

include_once("includes/vars.php");
include_once("includes/annotations.class.php");
include_once("includes/html_tag.class.php");
include_once("includes/form_element.class.php");
include_once("includes/form.class.php");
include_once("model/user.php");


$user = new user();
$form = $user->form;

?>


<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <form action="" method="POST" role="form" class="">
                <legend>Form title</legend>
            
                <div class="form-group">
                    <?php   
                        $form->name->class = "form-control";
                        $form->name->render();
                    ?>
                </div>

                <div class="form-group">
                    <?php   
                        $form->password->class = "form-control";
                        $form->password->render();
                    ?>
                </div>

                <div class="form-group">
                    <?php   
                        $form->telephone->class = "form-control";
                        $form->telephone->render();
                    ?>
                </div>
                
                <div class="form-group">
                    <?php   
                        $form->age->class = "form-control";
                        $form->age->render();
                    ?>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

