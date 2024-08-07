<?php 
require_once '../../Function/serverfunction.php';
require_once '../../Function/commonfunction.php';
if (isset($_POST["submit"]))
{   
    update(3, $_POST['sch_id'], $_POST['sch_day'],$_POST['sch_schedule']);
}
goToView();

?>