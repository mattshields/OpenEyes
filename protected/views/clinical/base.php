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
	'Clinical',
);

$this->menu=array(
);
?>

<?php

foreach ($this->eventTypes as $eventType) {
	echo CHtml::link(
                $eventType->name,
                Yii::app()->createUrl('clinical/create', array(
					'event_type_id' => $eventType->id
                ))
            );
	echo('&nbsp;');
}

?>
<br />
<br />
<?php

foreach ($this->episodes as $episode) {
	$episodeString = "episode: " . $episode->firm->serviceSpecialtyAssignment->specialty->name;

	if ($this->firm->serviceSpecialtyAssignment->specialty_id == $episode->firm->serviceSpecialtyAssignment->specialty_id) {
		$episodeString = '<b>' . $episodeString . '</b>';
	}

	echo CHtml::link(
                $episodeString,
                Yii::app()->createUrl('clinical/episodeSummary', array(
					'id' => $episode->id
                ))
            );

	echo("<br />\n");

	foreach ($episode->events as $event) {
		echo("&nbsp;&nbsp;event: " . $event->datetime . "&nbsp;&nbsp;");

		echo CHtml::link(
                'view',
                Yii::app()->createUrl('clinical/view', array(
					'id' => $event->id
                ))
            );
		echo('&nbsp;');

		if ($this->firm->serviceSpecialtyAssignment->specialty_id == $event->episode->firm->serviceSpecialtyAssignment->specialty_id) {
			echo CHtml::link(
	                'update',
	                Yii::app()->createUrl('clinical/update', array(
						'id' => $event->id
	                ))
	            );
		}

		echo('<br />');
	}
}
