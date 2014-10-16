<div style='margin-left:35px;'><?php
$id = $_GET['id'];
echo Advertisement::model()->findByPk($id)->content;  
?>
</div>