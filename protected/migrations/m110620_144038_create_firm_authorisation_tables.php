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

class m110620_144038_create_firm_authorisation_tables extends CDbMigration
{
	public function up()
	{
		$this->addColumn('referral', 'closed', 'tinyint(1) DEFAULT 0');

		$this->addColumn('user', 'global_firm_rights', 'tinyint(1) unsigned NOT NULL DEFAULT 0');

		$this->addColumn('specialty', 'ref_spec', 'char(3) NOT NULL');

		$this->createTable('user_firm_rights', array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                        'user_id' => 'int(10) unsigned NOT NULL',
			'firm_id' => 'int(10) unsigned NOT NULL',
                        'PRIMARY KEY (`id`)',
                ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
                );

                $this->createTable('user_service_rights', array(
                        'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                        'user_id' => 'int(10) unsigned NOT NULL',
                        'service_id' => 'int(10) unsigned NOT NULL',
                        'PRIMARY KEY (`id`)',
                ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
                );

		$this->addForeignKey('user_firm_rights_fk_1', 'user_firm_rights', 'user_id', 'user', 'id');
		$this->addForeignKey('user_firm_rights_fk_2', 'user_firm_rights', 'firm_id', 'firm', 'id');

        	$this->addForeignKey('user_service_rights_fk_1', 'user_service_rights', 'user_id', 'user', 'id');
        	$this->addForeignKey('user_service_rights_fk_2', 'user_service_rights', 'service_id', 'service', 'id');
        }

        public function down()
        {
		$this->dropColumn('referral', 'closed');

		$this->dropColumn('user', 'global_firm_rights');

		$this->dropColumn('specialty', 'ref_spec');

		$this->dropForeignKey('user_firm_rights_fk_1', 'user_firm_rights');
		$this->dropForeignKey('user_firm_rights_fk_2', 'user_firm_rights');

                $this->dropForeignKey('user_service_rights_fk_1', 'user_service_rights');
                $this->dropForeignKey('user_service_rights_fk_2', 'user_service_rights');

		$this->dropTable('user_service_rights');
		$this->dropTable('user_firm_rights');
	}
}
