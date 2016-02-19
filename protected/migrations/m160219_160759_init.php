<?php

class m160219_160759_init extends CDbMigration
{
    public function up()
    {
        $this->createTable('tbl_users', array(
            'id' => 'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'first_name' => "VARCHAR(32) NOT NULL COMMENT 'имя'",
            'last_name' => "VARCHAR(32) COMMENT 'фамилия'",
            'email' => "VARCHAR(128) NOT NULL COMMENT 'электронная почта'"
        ), "COMMENT 'Пользователи'");

        $this->insertMultiple('tbl_users', array(
            array('first_name' => 'Вася', 'last_name' => 'Васильев', 'email' => 'u1@va.com'),
            array('first_name' => 'Петя', 'last_name' => 'Николаев', 'email' => 'u2@va.com'),
            array('first_name' => 'Боря', 'last_name' => 'Расторгуев', 'email' => 'u3@va.com'),
            array('first_name' => 'Коля', 'last_name' => 'Атрибунов', 'email' => 'u4@va.com'),
            array('first_name' => 'Саша', 'last_name' => 'Мишкин', 'email' => 'u5@va.com'),
            array('first_name' => 'Женя', 'last_name' => 'Малышев', 'email' => 'u6@va.com'),
            array('first_name' => 'Арни', 'last_name' => 'Шварцнегер', 'email' => 'u7@va.com'),
        ));
    }

    public function down()
    {
        $this->dropTable('tbl_users');
    }
}
