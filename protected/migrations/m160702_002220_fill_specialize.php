<?php

class m160702_002220_fill_specialize extends DbMigration {
	public function safeUp() {
                $this->insert('specialize', ['name' => 'Аллерголог']);	
                $this->insert('specialize', ['name' => 'Гинеколог']);	
                $this->insert('specialize', ['name' => 'Дерматолог']);
                $this->insert('specialize', ['name' => 'Диетолог']);	
                $this->insert('specialize', ['name' => 'Косметолог']);
                $this->insert('specialize', ['name' => 'Логопед']);	
                $this->insert('specialize', ['name' => 'ЛОР']);
                $this->insert('specialize', ['name' => 'Маммолог']);	
                $this->insert('specialize', ['name' => 'Массажист']);
                $this->insert('specialize', ['name' => 'Невролог']);	
                $this->insert('specialize', ['name' => 'Педиатр']);
                $this->insert('specialize', ['name' => 'Психиатр']);	
                $this->insert('specialize', ['name' => 'Психолог']);
                $this->insert('specialize', ['name' => 'Психотерапевт']);	
                $this->insert('specialize', ['name' => 'Стоматолог']);
                $this->insert('specialize', ['name' => 'Терапевт']);	
                $this->insert('specialize', ['name' => 'Уролог']);
                $this->insert('specialize', ['name' => 'Хирург']);	
                $this->insert('specialize', ['name' => 'Эндокринолог']);	
                $this->insert('specialize', ['name' => 'Травматолог']);
	}

	public function safeDown() {
                $this->delete('specialize');
	}
}
          