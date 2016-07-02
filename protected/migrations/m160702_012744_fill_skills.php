<?php

class m160702_012744_fill_skills extends DbMigration {
	public function safeUp() {
            $this->insert('skills', ['doctorId' => '1', 'specializeId'=>'1']); 
            $this->insert('skills', ['doctorId' => '2', 'specializeId'=>'2']); 
            $this->insert('skills', ['doctorId' => '3', 'specializeId'=>'3']); 
            $this->insert('skills', ['doctorId' => '4', 'specializeId'=>'4']); 
            $this->insert('skills', ['doctorId' => '5', 'specializeId'=>'5']); 
            $this->insert('skills', ['doctorId' => '6', 'specializeId'=>'6']); 
            $this->insert('skills', ['doctorId' => '7', 'specializeId'=>'7']); 
            $this->insert('skills', ['doctorId' => '8', 'specializeId'=>'8']); 
            $this->insert('skills', ['doctorId' => '9', 'specializeId'=>'9']); 
            $this->insert('skills', ['doctorId' => '10', 'specializeId'=>'10']); 
            $this->insert('skills', ['doctorId' => '1', 'specializeId'=>'11']); 
            $this->insert('skills', ['doctorId' => '2', 'specializeId'=>'12']); 
            $this->insert('skills', ['doctorId' => '3', 'specializeId'=>'13']); 
            $this->insert('skills', ['doctorId' => '4', 'specializeId'=>'14']); 
            $this->insert('skills', ['doctorId' => '5', 'specializeId'=>'15']); 
            $this->insert('skills', ['doctorId' => '6', 'specializeId'=>'16']); 
            $this->insert('skills', ['doctorId' => '7', 'specializeId'=>'17']); 
            $this->insert('skills', ['doctorId' => '8', 'specializeId'=>'18']); 
            $this->insert('skills', ['doctorId' => '9', 'specializeId'=>'19']); 
            $this->insert('skills', ['doctorId' => '10', 'specializeId'=>'20']); 
            $this->insert('skills', ['doctorId' => '4', 'specializeId'=>'14']); 
            $this->insert('skills', ['doctorId' => '6', 'specializeId'=>'16']); 
            $this->insert('skills', ['doctorId' => '8', 'specializeId'=>'18']); 
	}

	public function safeDown() {
            $this->delete('skills');
	}
}
