<?php
/*
_____________________________________________________________________________
(C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
(C) OpenEyes Foundation, 2011
This file is part of OpenEyes.
OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
_____________________________________________________________________________
http://www.openeyes.org.uk   info@openeyes.org.uk
--
*/

$this->breadcrumbs=array(
	'Firms'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Firm', 'url'=>array('index')),
	array('label'=>'Create Firm', 'url'=>array('create')),
	array('label'=>'Update Firm', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Firm', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Firm', 'url'=>array('admin')),
);
?>

<h1>View Firm #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name' => 'service_id',
			'value' => CHtml::encode($model->getServiceText())
		),
		array(
			'name' => 'specialty_id',
			'value' => CHtml::encode($model->getSpecialtyText())
		),
		'pas_code',
		'name',
	),
)); ?>
