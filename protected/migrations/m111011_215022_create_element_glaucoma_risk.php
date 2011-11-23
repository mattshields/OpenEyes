<?php

class m111011_215022_create_element_glaucoma_risk extends CDbMigration
{
    public function up()
    {
		$this->createTable('element_glaucoma_risk', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'event_id' => 'int(10) unsigned NOT NULL',
			'myopia' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'migraine' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'cva' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'blood_loss' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'raynauds' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'foh' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'hyperopia' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'cardiac_surgery' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'angina' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'asthma' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'sob' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'hypotension' => "tinyint(1) unsigned NOT NULL DEFAULT '0'",
			'PRIMARY KEY (`id`)',
			'UNIQUE KEY `event_id` (`event_id`)'
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('element_type', array(
			'name' => 'Glaucoma Risk',
			'class_name' => 'ElementGlaucomaRisk'
		));
		$elementType = $this->dbConnection->createCommand()
			->select('id')
			->from('element_type')
			->where('name=:name AND class_name=:class', 
				array(':name'=>'Glaucoma Risk', ':class'=>'ElementGlaucomaRisk'))
			->queryRow();

		$this->insert('possible_element_type', array(
			'event_type_id' => 1, // examination
			'element_type_id' => $elementType['id'],
			'num_views' => 1,
			'display_order' => 8
		));

		$possibleElement = $this->dbConnection->createCommand()
			->select('id')
			->from('possible_element_type')
			->where('event_type_id=:eventType AND 
				element_type_id=:elementType AND num_views=:num AND 
				`display_order`=:display_order',
				array(':eventType'=>1,':elementType'=>$elementType['id'],
					':num'=>1,':display_order'=>8))
			->queryRow();		

		$this->insert('site_element_type', array(
			'possible_element_type_id' => $possibleElement['id'],
			'specialty_id' => 7, // Glaucoma
			'view_number' => 1,
			'required' => 1,
			'first_in_episode' => 1
		));
		$this->insert('site_element_type', array(
			'possible_element_type_id' => $possibleElement['id'],
			'specialty_id' => 7, // Glaucoma
			'view_number' => 1,
			'required' => 1,
			'first_in_episode' => 0
		));
    }

    public function down()
    {
		$elementType = $this->dbConnection->createCommand()
			->select('id')
			->from('element_type')
			->where('name=:name AND class_name=:class', 
				array(':name'=>'Glaucoma Risk', ':class'=>'ElementGlaucomaRisk'))
			->queryRow();

		if ($elementType) {
			$possibleElement = $this->dbConnection->createCommand()
				->select('id')
				->from('possible_element_type')
				->where('event_type_id=:eventType AND 
					element_type_id=:elementType AND num_views=:num AND 
					`display_order`=:display_order',
					array(':eventType'=>1,':elementType'=>$elementType['id'],
						':num'=>1,':display_order'=>8))
				->queryRow();
			$this->delete('site_element_type', 'possible_element_type_id = :id',
				array(':id' => $possibleElement['id'])
			);

			$this->delete('possible_element_type', 'element_type_id = :id',
				array(':id' => $elementType['id'])
			);
		}
		
		$this->delete('element_type', 'class_name = :class', 
			array(':class' => 'ElementGlaucomaRisk')
		);

		$this->dropTable('element_glaucoma_risk');
    }
}