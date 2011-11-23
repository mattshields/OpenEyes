<?php

/**
 * This is the model class for table "element_glaucoma_risk".
 *
 * The followings are the available columns in table 'element_glaucoma_risk':
 * @property string $id
 * @property string $event_id
 * @property integer $myopia
 * @property integer $migraine
 * @property integer $cva
 * @property integer $blood_loss
 * @property integer $raynauds
 * @property integer $foh
 * @property integer $hyperopia
 * @property integer $cardiac_surgery
 * @property integer $angina
 * @property integer $asthma
 * @property integer $sob
 * @property integer $hypotension
 */
class ElementGlaucomaRisk extends BaseElement
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ElementGlaucomaRisk the static model class
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
		return 'element_glaucoma_risk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id', 'required'),
			array('myopia, migraine, cva, blood_loss, raynauds, foh, hyperopia, cardiac_surgery, angina, asthma, sob, hypotension', 'numerical', 'integerOnly'=>true),
			array('id, event_id, myopia, migraine, cva, blood_loss, raynauds, foh, hyperopia, cardiac_surgery, angina, asthma, sob, hypotension', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'myopia' => 'Myopia',
			'migraine' => 'Migraine',
			'cva' => 'Cva',
			'blood_loss' => 'Blood Loss',
			'raynauds' => 'Raynauds',
			'foh' => 'Foh',
			'hyperopia' => 'Hyperopia',
			'cardiac_surgery' => 'Cardiac Surgery',
			'angina' => 'Angina',
			'asthma' => 'Asthma',
			'sob' => 'Sob',
			'hypotension' => 'Hypotension',
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
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('myopia',$this->myopia);
		$criteria->compare('migraine',$this->migraine);
		$criteria->compare('cva',$this->cva);
		$criteria->compare('blood_loss',$this->blood_loss);
		$criteria->compare('raynauds',$this->raynauds);
		$criteria->compare('foh',$this->foh);
		$criteria->compare('hyperopia',$this->hyperopia);
		$criteria->compare('cardiac_surgery',$this->cardiac_surgery);
		$criteria->compare('angina',$this->angina);
		$criteria->compare('asthma',$this->asthma);
		$criteria->compare('sob',$this->sob);
		$criteria->compare('hypotension',$this->hypotension);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}