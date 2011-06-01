<?php
$this->breadcrumbs=array(
	'Global phrases'=>array('index'),
	 $model->id => array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Phrase', 'url'=>array('index')),
	array('label'=>'Create Phrase', 'url'=>array('create')),
	array('label'=>'View Phrase', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update global phrase: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
