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

class m110629_141805_alter_gp_contact_tables extends CDbMigration
{
	public function up()
	{
		$this->addColumn('contact', 'title', 'varchar(20) NOT NULL');
		$this->addColumn('contact', 'first_name', 'varchar(100) NOT NULL');
		$this->addColumn('contact', 'last_name', 'varchar(100) NOT NULL');
		$this->addColumn('contact', 'qualifications', 'varchar(200) DEFAULT NULL');

		$this->createTable('gp', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'obj_prof' => 'varchar(20) NOT NULL',
			'nat_id' => 'varchar(20) NOT NULL',
			'contact_id' => 'int(10) unsigned NOT NULL',
			'PRIMARY KEY (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->addForeignKey('gp_contact_id_fk_1', 'gp', 'contact_id', 'contact', 'id');

		$this->alterColumn('address', 'address1', 'varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL');
		$this->alterColumn('address', 'address2', 'varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL');
		$this->alterColumn('address', 'city', 'varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL');
		$this->alterColumn('address', 'county', 'varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL');
		$this->alterColumn('address', 'email', 'varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL');

		$this->createTable('consultant', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'obj_prof' => 'varchar(20) NOT NULL',
			'nat_id' => 'varchar(20) NOT NULL',
			'contact_id' => 'int(10) unsigned NOT NULL',
			'PRIMARY KEY (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->addForeignKey('consultant_contact_id_fk_1', 'consultant', 'contact_id', 'contact', 'id');

		$this->createTable('manual_contact', array(
			'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'contact_type_id' => 'INT(10) unsigned NOT NULL',
			'contact_id' => 'int(10) unsigned NOT NULL',
			'PRIMARY KEY (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->addForeignKey('manual_contact_contact_id_fk_1', 'manual_contact', 'contact_id', 'contact', 'id');
		$this->addForeignKey('manual_contact_contact_type_id_fk_2', 'manual_contact', 'contact_type_id', 'contact_type', 'id');

		$this->dropForeignKey('letter_template_ibfk_2', 'letter_template');
		$this->dropColumn('letter_template', 'contact_type_id');
		$this->addColumn('letter_template', 'to', 'INT(10) UNSIGNED NOT NULL');
		$this->dropColumn('letter_template', 'cc');
		$this->addColumn('letter_template', 'cc', 'INT(10) UNSIGNED NOT NULL');
		$this->addForeignKey('letter_template_ibfk_2', 'letter_template', 'to', 'contact_type', 'id');
		$this->addForeignKey('letter_template_ibfk_3', 'letter_template', 'cc', 'contact_type', 'id');
		$this->dropColumn('letter_template', 'text');
		$this->addColumn('letter_template', 'phrase', 'TEXT NOT NULL');

		$this->dropColumn('contact_type', 'macro_only');
		$this->addColumn('contact_type', 'letter_template_only', 'TINYINT NOT NULL DEFAULT 0');

		$this->update('contact_type', array('letter_template_only' => 1), "name='GP'");

		$this->insert('contact_type', array(
			'name' => 'Consultant',
			'letter_template_only' => 1
		));

		$this->dropForeignKey('contact_type_fk', 'contact');

		$this->dropColumn('contact', 'consultant');
		$this->dropColumn('contact', 'contact_type_id');

		// Make the only default user, admin, a consultant so they can use letter_templates
		$this->insert('address', array(
			'address1' => 'Example address line 1',
			'address2' => 'Example address line 2',
			'city' => 'Example city',
			'county' => 'Example county',
			'postcode' => 'A1 2CD',
			'email' => 'example@opeyes.org.uk',
			'country_id' => 1
		));

		$address = $this->dbConnection->createCommand()->select('id')->from('address')->where('address1=:address1', array(':address1' => 'Example address line 1'))->queryRow();

		$this->insert('contact', array(
			'address_id' => $address['id'],
			'first_name' => 'Example first name',
			'last_name' => 'Example last name',
			'nick_name' => 'Example nickname',
			'primary_phone' => 'Example primary phone'
		));

		$contact = $this->dbConnection->createCommand()->select('id')->from('contact')->where('address_id=:address_id', array(':address_id' => $address['id']))->queryRow();

		$user = $this->dbConnection->createCommand()->select('id')->from('user')->where('username=:username', array(':username' => 'admin'))->queryRow();

		$this->insert('user_contact_assignment', array(
			'user_id' => $user['id'],
			'contact_id' => $contact['id']
		));

		$this->insert('consultant', array(
			'contact_id' => $contact['id'],
			'obj_prof' => 'Example',
			'nat_id' => 'Example'
		));
	}

	public function down()
	{
		$command = $this->dbConnection->createCommand('SET foreign_key_checks = 0;');
		$command->execute();

		$this->truncateTable('contact');

		$this->delete('contact_type', 'name=:name', array(':name' => 'Consultant'));

		$command = $this->dbConnection->createCommand('SET foreign_key_checks = 1;');
		$command->execute();

		$this->dropColumn('contact_type', 'letter_template_only');
		$this->addColumn('contact_type', 'macro_only', 'TINYINT NOT NULL DEFAULT 0');

		$this->addColumn('contact', 'consultant', 'TINYINT NOT NULL DEFAULT 0');
		$this->addColumn('contact', 'contact_type_id', 'INT(10) UNSIGNED NOT NULL');

		$this->addForeignKey('contact_type_fk', 'contact', 'contact_type_id', 'contact_type', 'id');

		$address = $this->dbConnection->createCommand()->select('id')->from('address')->where('address1=:address1', array(':address1' => 'Example address line 1'))->queryRow();

		$user = $this->dbConnection->createCommand()->select('id')->from('user')->where('username=:username', array(':username' => 'admin'))->queryRow();

		$this->delete('address', 'id=:id', array(':id' => $address['id']));
		$this->delete('contact', 'address_id=:address_id', array(':address_id' => $address['id']));
		$this->delete('user_contact_assignment', 'user_id=:user_id', array(':user_id' => $user['id']));

		$this->dropColumn('letter_template', 'phrase');
		$this->addColumn('letter_template', 'text', 'TEXT NOT NULL');
		$this->dropForeignKey('letter_template_ibfk_3', 'letter_template');
		$this->addColumn('letter_template', 'contact_type_id', 'INT(10) UNSIGNED NOT NULL');
		$this->dropForeignKey('letter_template_ibfk_2', 'letter_template');
		$this->dropIndex('letter_template_ibfk_2', 'letter_template');
		$this->dropColumn('letter_template', 'cc');
		$this->addColumn('letter_template', 'cc', 'VARCHAR(128) NOT NULL');
		$this->dropColumn('letter_template', 'to');
		$this->addForeignKey('letter_template_ibfk_2', 'letter_template', 'contact_type_id', 'contact_type', 'id');

		$this->dropTable('manual_contact');

		$this->dropTable('consultant');

		$this->dropTable('gp');

		$this->dropColumn('contact', 'qualifications');
		$this->dropColumn('contact', 'last_name');
		$this->dropColumn('contact', 'first_name');
		$this->dropColumn('contact', 'title');
	}
}
