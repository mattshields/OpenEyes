        <?php

class m111010_194623_glaucoma_site_element_setup extends CDbMigration {

    public function up() {
        // delete the existing examination entries for site_element_type
        $this->delete('site_element_type', 'specialty_id = :specialty_id', array(':specialty_id' => 7));
        
        // delete the entries where possible_element_type_id is in the range 1-16
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 1));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 2));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 3));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 4));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 5));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 6));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 7));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 8));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 9));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 10));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 11));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 12));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 13));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 14));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 15));
        $this->delete('site_element_type', 'possible_element_type_id = :possible_element_type_id', 
                array(':possible_element_type_id' => 16));

        

        // delete the existing examination entries for possible_element_type
        $this->delete('possible_element_type', 'event_type_id = :event_type_id', array(':event_type_id' => 1));

        // add new possible_element_type mapings
        $possible_elem_type_data = array(
            // id, event_type_id, element_type_id, num_views, display_order
            "(1, 1, 13, 1, 1)",
            // TODO iop at presentation
            "(3, 1, 23, 1, 3)",
            "(4, 1, 17, 1, 4)",
            "(5, 1, 18, 1, 5)",
            "(6, 1, 19, 1, 6)",
            "(7, 1, 22, 1, 7)",
            // TODO risks
            "(9, 1, 4, 1, 9)",
            "(10, 1, 10, 1, 10)",
            "(11, 1, 13, 1, 11)",
            // TODO CCT
            "(13, 1, 12, 1, 13)",
            "(14, 1, 14, 1, 14)",
            "(15, 1, 16, 1, 15)",
            "(16, 1, 31, 1, 16)"
        );
        $sql = "INSERT INTO `possible_element_type` (`id`, `event_type_id`, `element_type_id`, `num_views`, `display_order`) VALUES\n";
        foreach ($possible_elem_type_data as $values) {
            $sql .= $values;
            if ($values != end($possible_elem_type_data)) {
                $sql .= ", ";
            }
            $sql .= "\n";
        }
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();

        // add new site_element_type mapings
        $site_elem_type_data = array(
            // id, possible_element_type_id, specialty_id, view_number, required, first_in_episode
            "(1, 7, 1, 1, 1)",
            "(1, 7, 1, 0, 0)",
            "(3, 7, 1, 1, 1)",
            "(3, 7, 1, 0, 0)",
            "(4, 7, 1, 1, 1)",
            "(4, 7, 1, 0, 0)",
            "(5, 7, 1, 1, 1)",
            "(5, 7, 1, 0, 0)",
            "(6, 7, 1, 1, 1)",
            "(6, 7, 1, 0, 0)",
            "(7, 7, 1, 1, 1)",
            "(7, 7, 1, 0, 0)",
            "(9, 7, 1, 1, 1)",
            "(9, 7, 1, 0, 0)",
            "(10, 7, 1, 1, 1)",
            "(10, 7, 1, 0, 0)",
            "(11, 7, 1, 1, 1)",
            "(11, 7, 1, 0, 0)",
            "(13, 7, 1, 0, 1)",
            "(13, 7, 1, 0, 0)",
            "(14, 7, 1, 1, 1)",
            "(14, 7, 1, 0, 0)",
            "(15, 7, 1, 1, 1)",
            "(15, 7, 1, 0, 0)",
            "(16, 7, 1, 1, 1)",
            "(16, 7, 1, 0, 0)",
        );
        $sql = "INSERT INTO `site_element_type` (`possible_element_type_id`, `specialty_id`, `view_number`, `required`, `first_in_episode`) VALUES\n";
        foreach ($site_elem_type_data as $values) {
            $sql .= $values;
            if ($values != end($site_elem_type_data)) {
                $sql .= ", ";
            }
            $sql .= "\n";
        }
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
    }

    public function down() {
        // delete the new site_element_type values
        $this->delete('site_element_type', 'specialty_id = :specialty_id', array(':specialty_id' => 7));

        //remove possible_element_type values
        $this->delete('possible_element_type', 'event_type_id = :event_type_id', array(':event_type_id' => 26));

        // add back the default possible_element_type entries
        // TODO

        // insert the default site_element_type values  
        $default_rows = array(
            // id, possible_element_type_id, specialty_id, view_number, required, first_in_episode
            "(7, 1, 7, 1, 1, 1)",
            "(23, 1, 7, 1, 0, 0)",
            "(39, 2, 7, 1, 1, 1)",
            "(55, 2, 7, 1, 0, 0)",
            "(71, 3, 7, 1, 1, 1)",
            "(87, 3, 7, 1, 0, 0)",
            "(103, 4, 7, 1, 1, 1)",
            "(119, 4, 7, 1, 0, 0)",
            "(135, 5, 7, 1, 1, 1)",
            "(151, 5, 7, 1, 0, 0)",
            "(167, 6, 7, 1, 1, 1)",
            "(183, 6, 7, 1, 0, 0)",
            "(198, 7, 7, 1, 1, 1)",
            "(213, 7, 7, 1, 1, 0)",
            "(228, 8, 7, 1, 1, 1)",
            "(243, 8, 7, 1, 1, 0)",
            "(258, 9, 7, 1, 1, 1)",
            "(273, 9, 7, 1, 1, 0)",
            "(299, 13, 7, 1, 1, 0)",
            "(300, 13, 7, 1, 1, 1)",
            "(329, 14, 7, 1, 1, 0)",
            "(330, 14, 7, 1, 1, 1)",
            "(397, 18, 7, 1, 1, 0)",
            "(398, 18, 7, 1, 1, 1)",
            "(423, 19, 7, 1, 1, 0)",
            "(445, 20, 7, 1, 1, 0)",
            "(446, 20, 7, 1, 1, 1)"
        );
        $sql = "INSERT INTO `site_element_type` (`id`, `possible_element_type_id`, `specialty_id`, `view_number`, `required`, `first_in_episode`) VALUES\n";
        foreach ($default_rows as $values) {
            $sql .= $values;
            if ($values != end($default_rows)) {
                $sql .= ", ";
            }
            $sql .= "\n";
        }
        $command = $this->dbConnection->createCommand($sql);
        $command->execute();
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