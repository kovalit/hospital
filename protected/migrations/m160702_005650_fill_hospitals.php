<?php

class m160702_005650_fill_hospitals extends DbMigration {
	public function safeUp() {
            $this->insert('hospitals', ['name' => 'Клиника "Диагност" мкр. Горский, 8']);
            $this->insert('hospitals', ['name' => 'Клиника "Инсайт" ул. Б. Богаткова, 24']);
            $this->insert('hospitals', ['name' => 'Клиника профессора Лантуха ул. Тополевая, 26']);
            $this->insert('hospitals', ['name' => 'Больница клиническая СО РАН ул. Пирогова, 25']);
            $this->insert('hospitals', ['name' => 'Больница городская № 3 ул. Мухачева, 5']);
            $this->insert('hospitals', ['name' => 'Больница городская клиническая № 1 ул. Залесского, 6']);
            $this->insert('hospitals', ['name' => 'Больница городская клиническая № 11 ул. Танкистов, 23']);
            $this->insert('hospitals', ['name' => 'Больница городская клиническая № 1 ул. Залесского, 6']);
            $this->insert('hospitals', ['name' => 'Поликлиника городская № 6 ул. Александра Невского, 1а']);
            $this->insert('hospitals', ['name' => 'Поликлиника городская № 18 ул. Широкая, 113']);
            $this->insert('hospitals', ['name' => 'Поликлиника городская № 28 ул. Связистов, 157']);
            $this->insert('hospitals', ['name' => 'Отдел здравоохранения пр. Лаврентьева, 14']);
            $this->insert('hospitals', ['name' => 'Госпиталь ветеранов войн № 3 ул. Демьяна Бедного, 71']);
            $this->insert('hospitals', ['name' => 'Больница психиатрическая областная № 2 ул. Бердышева, 2']);
	}

	public function safeDown() {
            $this->delete('hospitals');
	}
}
