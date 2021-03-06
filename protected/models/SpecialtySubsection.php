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

/**
 * This is the model class for table "specialty_subsection".
 *
 * The followings are the available columns in table 'specialty_subsection':
 * @property string $id
 * @property string $specialty_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Procedure[] $procedures
 * @property Specialty $specialty
 */
class SpecialtySubsection extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ServiceSubsection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'specialty_subsection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('specialty_id, name', 'required'),
			array('specialty_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, specialty_id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'procedures' => array(self::MANY_MANY, 'Procedure', 'proc_specialty_subsection_assignment(proc_id, specialty_subsection_id)'),
			'specialty' => array(self::BELONGS_TO, 'Specialty', 'specialty_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'specialty_id' => 'Specialty',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('specialty_id',$this->specialty_id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getList($specialtyId)
	{
		$sections = Yii::app()->db->createCommand()
			->select('id, name')
			->from('specialty_subsection')
			->where('specialty_id = :id',
				array(':id'=>$specialtyId))
			->order('name ASC')
			->queryAll();

		$data = array();

		foreach ($sections as $section) {
			$data[$section['id']] = $section['name'];
		}

		return $data;
	}
}