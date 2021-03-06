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
 * This is the model class for table "common_ophthalmic_disorder".
 *
 * The followings are the available columns in table 'common_ophthalmic_disorder':
 * @property string $id
 * @property string $disorder_id
 * @property string $specialty_id
 *
 * The followings are the available model relations:
 * @property Disorder $disorder
 * @property Specialty $specialty
 */
class CommonOphthalmicDisorder extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CommonOphthalmicDisorder the static model class
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
		return 'common_ophthalmic_disorder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('disorder_id, specialty_id', 'required'),
			array('disorder_id, specialty_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, disorder_id, specialty_id', 'safe', 'on'=>'search'),
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
			'disorder' => array(self::BELONGS_TO, 'Disorder', 'disorder_id'),
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
			'disorder_id' => 'Disorder',
			'specialty_id' => 'Specialty',
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
		$criteria->compare('disorder_id',$this->disorder_id,true);
		$criteria->compare('specialty_id',$this->specialty_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function getSpecialtyOptions()
	{
		$specialties = Yii::app()->db->createCommand()
			->select('s.id, s.name')
			->from('specialty s')
			->order('name ASC')
			->queryAll();

		return CHtml::listData($specialties, 'id', 'name');
	}

	public static function getList($firm)
	{
		if (empty($firm)) {
			throw new Exception('Firm is required.');
		}

		$options = Yii::app()->db->createCommand()
			->select('t.id AS did, t.term')
			->from('disorder t')
			->join('common_ophthalmic_disorder', 't.id = common_ophthalmic_disorder.disorder_id')
			->where('common_ophthalmic_disorder.specialty_id = :specialty_id',
				array(':specialty_id' => $firm->serviceSpecialtyAssignment->specialty_id))
			->queryAll();

		$result = array();
		foreach ($options as $value) {
			$result[$value['did']] = $value['term'];
		}

		return $result;
	}
}