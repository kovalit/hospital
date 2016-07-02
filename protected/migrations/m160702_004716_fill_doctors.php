<?php

class m160702_004716_fill_doctors extends DbMigration {
	public function safeUp() {
            $this->insert('doctors', ['firstName' => 'Дмитрий', 'lastName'=>'СИДОРЕНКОВ']); 
            $this->insert('doctors', ['firstName' => 'Андрей', 'lastName'=>'ИСКОРНЕВ']); 
            $this->insert('doctors', ['firstName' => 'Эльмира', 'lastName'=>'БАЛТАЧЕЕВА']); 
            $this->insert('doctors', ['firstName' => 'Константин', 'lastName'=>'ЛИПСКИЙ']); 
            $this->insert('doctors', ['firstName' => 'Екатерина', 'lastName'=>'КУДИНОВА']); 
            $this->insert('doctors', ['firstName' => 'Дмитрий', 'lastName'=>'МЕЛЬНИКОВ']); 
            $this->insert('doctors', ['firstName' => 'Анна', 'lastName'=>'СМИРНОВА']); 
            $this->insert('doctors', ['firstName' => 'Эдуард', 'lastName'=>'ХАЛАФЬЯНЦ']); 
            $this->insert('doctors', ['firstName' => 'Ксения', 'lastName'=>'АВДОШЕНКО']); 
            $this->insert('doctors', ['firstName' => 'Антон', 'lastName'=>'ЗАХАРОВ']); 
            $this->insert('doctors', ['firstName' => 'Наталья', 'lastName'=>'САРКИСОВА']); 
	}

	public function safeDown() {
            $this->delete('doctors');
	}
}
