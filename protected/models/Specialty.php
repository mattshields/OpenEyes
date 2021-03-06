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
 * This is the model class for table "specialty".
 *
 * The followings are the available columns in table 'specialty':
 * @property string $id
 * @property string $name
 * @property string $class_name
 *
 * The followings are the available model relations:
 * @property EventTypeElementTypeAssignmentSpecialtyAssignment[] $eventTypeElementTypeAssignmentSpecialtyAssignments
 * @property ExamPhrase[] $examPhrases
 * @property LetterTemplate[] $letterTemplates
 * @property ServiceSpecialtyAssignment[] $serviceSpecialtyAssignments
 */
class Specialty extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Specialty the static model class
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
		return 'specialty';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, class_name', 'required'),
			array('name, class_name', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, class_name', 'safe', 'on'=>'search'),
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
//			'eventTypeElementTypeAssignmentSpecialtyAssignments' => array(self::HAS_MANY, 'EventTypeElementTypeAssignmentSpecialtyAssignment', 'specialty_id'),
			'siteElementTypes' => array(self::HAS_MANY, 'SiteElementType', 'specialty_id'),
			'examPhrases' => array(self::HAS_MANY, 'ExamPhrase', 'specialty_id'),
			'letterTemplates' => array(self::HAS_MANY, 'LetterTemplate', 'specialty_id'),
			'serviceSpecialtyAssignments' => array(self::HAS_MANY, 'ServiceSpecialtyAssignment', 'specialty_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'class_name' => 'Class Name',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('class_name',$this->class_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        /**
         * Fetch an array of specialty IDs and names
         * @return array
         */
        public function getList()
        {
                $list = Specialty::model()->findAll();
                $result = array();

                foreach ($list as $specialty) {
                        $result[$specialty->id] = $specialty->name;
                }

                return $result;
        }
}
