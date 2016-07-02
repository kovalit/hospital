<?php

class m160702_011925_fill_staff extends DbMigration {
	public function safeUp() {
            $this->insert('staff', ['doctorId' => '1', 'hospitalId'=>'1']); 
            $this->insert('staff', ['doctorId' => '2', 'hospitalId'=>'2']); 
            $this->insert('staff', ['doctorId' => '3', 'hospitalId'=>'3']); 
            $this->insert('staff', ['doctorId' => '4', 'hospitalId'=>'4']); 
            $this->insert('staff', ['doctorId' => '5', 'hospitalId'=>'5']); 
            $this->insert('staff', ['doctorId' => '6', 'hospitalId'=>'6']); 
            $this->insert('staff', ['doctorId' => '7', 'hospitalId'=>'7']); 
            $this->insert('staff', ['doctorId' => '8', 'hospitalId'=>'8']); 
            $this->insert('staff', ['doctorId' => '9', 'hospitalId'=>'9']); 
            $this->insert('staff', ['doctorId' => '10', 'hospitalId'=>'10']); 
            $this->insert('staff', ['doctorId' => '1', 'hospitalId'=>'10']); 
            $this->insert('staff', ['doctorId' => '2', 'hospitalId'=>'9']); 
            $this->insert('staff', ['doctorId' => '3', 'hospitalId'=>'8']); 
            $this->insert('staff', ['doctorId' => '4', 'hospitalId'=>'7']); 
            $this->insert('staff', ['doctorId' => '5', 'hospitalId'=>'6']); 
            $this->insert('staff', ['doctorId' => '6', 'hospitalId'=>'5']); 
            $this->insert('staff', ['doctorId' => '7', 'hospitalId'=>'4']); 
            $this->insert('staff', ['doctorId' => '8', 'hospitalId'=>'3']);
            $this->insert('staff', ['doctorId' => '9', 'hospitalId'=>'2']); 
            $this->insert('staff', ['doctorId' => '10', 'hospitalId'=>'1']); 


	}

	public function safeDown() {
            $this->delete('staff');
	}
}
