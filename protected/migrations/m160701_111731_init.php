<?php

class m160701_111731_init extends DbMigration {
	public function safeUp() {  
             $this->createTable('hospitals', [
			'id'                => 'int(8) unsigned NOT NULL AUTO_INCREMENT',
			'name'              => 'varchar(128) NOT NULL',
                        'active'            => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
			'PRIMARY KEY (`id`)',
            ]);
             
            $this->createTable('specialize', [
			'id'                => 'int(4) unsigned NOT NULL AUTO_INCREMENT',
			'name'              => 'varchar(32) NOT NULL',
			'PRIMARY KEY (`id`)',
            ]);
            
            $this->createTable('doctors', [
			'id'                => 'int(8) unsigned NOT NULL AUTO_INCREMENT',
			'firstName'         => 'varchar(16) NOT NULL',
			'middleName'        => 'varchar(16) NULL DEFAULT NULL',
			'lastName'          => 'varchar(32) NOT NULL',
                        'active'            => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
			'PRIMARY KEY (`id`)',
		]);
            
            $this->createTable('schedules', [
			'id'                => 'int(8) unsigned NOT NULL AUTO_INCREMENT',
                        'hospitalId'        => 'int(8) unsigned NOT NULL',
                        'doctorId'          => 'int(8) unsigned NOT NULL',
                        'scheme'            => 'text NOT NULL',
                        'version'           => 'varchar(4) NOT NULL',
                        'isException'       => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
                        'active'            => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
                        'created'           => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP', 
                        'PRIMARY KEY (`id`)',
                        'CONSTRAINT `schedules_doctors` FOREIGN KEY (`doctorId`) REFERENCES `doctors` (`id`)',
                        'CONSTRAINT `schedules_hospital` FOREIGN KEY (`hospitalId`) REFERENCES `hospitals` (`id`)',
		]);
            
            $this->createTable('staff', [
			'id'                => 'int(8) unsigned NOT NULL AUTO_INCREMENT',
                        'doctorId'          => 'int(8) unsigned NULL DEFAULT NULL',
                        'hospitalId'        => 'int(8) unsigned NULL DEFAULT NULL',
                        'active'            => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
                        'PRIMARY KEY (`id`)',
                        'CONSTRAINT `staff_doctors` FOREIGN KEY (`doctorId`) REFERENCES `doctors` (`id`)',
                        'CONSTRAINT `staff_hospital` FOREIGN KEY (`hospitalId`) REFERENCES `hospitals` (`id`)',
		]);
            
            $this->createTable('skills', [
			'id'                => 'int(8) unsigned NOT NULL AUTO_INCREMENT',
                        'doctorId'          => 'int(8) unsigned NULL DEFAULT NULL',
                        'specializeId'      => 'int(8) unsigned NULL DEFAULT NULL',
                        'PRIMARY KEY (`id`)',
                        'CONSTRAINT `skills_doctors` FOREIGN KEY (`doctorId`) REFERENCES `doctors` (`id`)',
                        'CONSTRAINT `skills_specialize` FOREIGN KEY (`specializeId`) REFERENCES `specialize` (`id`)',
		]);
            
            $this->createTable('users', [
			'id'                => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
                        'login'             => 'varchar(32) NOT NULL',
                        'name'              => 'varchar(64) NULL DEFAULT NULL',
                        'email'             => 'varchar(64) NULL DEFAULT NULL',
                        'phone'             => 'varchar(10) NULL DEFAULT NULL',
                        'pass'              => 'varchar(16) NULL DEFAULT NULL',
                        'salt'              => 'varchar(64) NULL DEFAULT NULL',
                        'active'            => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
                        'source'            => 'varchar(32) NULL DEFAULT NULL',
                        'isReg'             => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
                        'created'           => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP', 
                        'PRIMARY KEY (`id`)',
		]);
            
             $this->createTable('booking', [
			'id'                => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
                        'doctorId'          => 'int(8) unsigned NOT NULL',
                        'hospitalId'        => 'int(8) unsigned NOT NULL',
                        'userId'            => 'int(8) unsigned NOT NULL',
                        'date'              => 'date NULL DEFAULT NULL',
                        'start'             => 'time NOT NULL',
                        'end'               => 'time NOT NULL',
                        'active'            => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
                        'created'           => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',              
                        'PRIMARY KEY (`id`)',
                        'CONSTRAINT `booking_doctors` FOREIGN KEY (`doctorId`) REFERENCES `doctors` (`id`)',
                        'CONSTRAINT `booking_hospitals` FOREIGN KEY (`hospitalId`) REFERENCES `hospitals` (`id`)',
                        'CONSTRAINT `booking_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)',
		]);
            
          
	}

	public function safeDown() {
            $this->dropTable('booking');
            $this->dropTable('schedules');
            $this->dropTable('users');
            $this->dropTable('skills');
            $this->dropTable('staff');
            $this->dropTable('doctors');
            $this->dropTable('specialize');
            $this->dropTable('hospitals'); 
	}
}
