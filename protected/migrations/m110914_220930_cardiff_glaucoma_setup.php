<?php

class m110914_220930_cardiff_glaucoma_setup extends CDbMigration
{
	public function up()
	{
            $gl_service = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('service')
                    ->where('name = :name', array(':name' => 'Glaucoma Service'))
                    ->queryRow();
            $gl_specialty = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('specialty')
                    ->where('name = :name', array(':name' => 'Glaucoma'))
                    ->queryRow();

            // set up service/speciality link for Glaucoma
            $this->insert('service_specialty_assignment', array(
                'service_id' => $gl_service['id'],
                'specialty_id' => $gl_specialty['id'])
            );
            
            // get service/specialty link row
            $ssa = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('service_specialty_assignment')
                    ->where('service_id = :service_id and specialty_id = :specialty_id', 
                            array(':service_id' => $gl_service['id'],
                                ':specialty_id' => $gl_specialty['id'])
                            )
                    ->queryRow();
            
            // set up a dummy firm for Cardiff Glaucoma
            $this->insert('firm', array(
                'service_specialty_assignment_id' => $ssa['id'],
                'pas_code' => 'CDFG',
                'name' => 'Cardiff Glaucoma')
            );

            // get the firm id
            $firm = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('firm')
                    ->where('service_specialty_assignment_id = :service_specialty_assignment_id
                        and pas_code = :pas_code and name = :name',
                    array(':service_specialty_assignment_id' => $ssa['id'],
                        ':pas_code' => 'CDFG', ':name' => 'Cardiff Glaucoma'))
                    ->queryRow();

            // add the default user
            $this->insert('firm_user_assignment', array('firm_id' => $firm['id'], 'user_id' => 1)
            );
	}

	public function down()
	{
            $gl_service = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('service')
                    ->where('name = :name', array(':name' => 'Glaucoma Service'))
                    ->queryRow();
            $gl_specialty = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('specialty')
                    ->where('name = :name', array(':name' => 'Glaucoma'))
                    ->queryRow();
            $ssa = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('service_specialty_assignment')
                    ->where('service_id = :service_id and specialty_id = :specialty_id', 
                            array(':service_id' => $gl_service['id'],
                                ':specialty_id' => $gl_specialty['id'])
                            )
                    ->queryRow();
            $firm = $this->getDbConnection()->createCommand()
                    ->select('id')
                    ->from('firm')
                    ->where('service_specialty_assignment_id = :service_specialty_assignment_id
                        and pas_code = :pas_code and name = :name',
                    array(':service_specialty_assignment_id' => $ssa['id'],
                        ':pas_code' => 'CDFG', ':name' => 'Cardiff Glaucoma'))
                    ->queryRow();
            
            // delete the default user
            $this->delete('firm_user_assignment', 'firm_id = :firm_id and user_id = :user_id',
                    array(':firm_id' => $firm['id'], ':user_id' => 1)
            );
            
            // delete dummy firm for Cardiff Glaucoma
            $this->delete('firm',
                    'service_specialty_assignment_id = :service_specialty_assignment_id
                        and pas_code = :pas_code and name = :name',
                    array(':service_specialty_assignment_id' => $ssa['id'],
                        ':pas_code' => 'CDFG', ':name' => 'Cardiff Glaucoma')
            );

            // delete service/speciality link for Glaucoma
            $this->delete('service_specialty_assignment', 
                    'service_id = :service_id and specialty_id = :specialty_id', 
                    array(':service_id' => $gl_service['id'], ':specialty_id' => $gl_specialty['id'])
            );
            
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}