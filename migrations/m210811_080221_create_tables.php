<?php

use yii\db\Migration;

/**
 * Class m210811_080221_create_tables
 */
class m210811_080221_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE `user` (
            `id` int NOT NULL,
            `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
            `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;');

        $this->execute('ALTER TABLE `user`
            ADD PRIMARY KEY (`id`),
            ADD UNIQUE KEY `username` (`username`) USING BTREE;');

        $this->execute('ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;');
        
        $this->execute('CREATE TABLE `repo` (
            `id` int NOT NULL,
            `user_id` int NOT NULL,
            `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
            `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
            `updated_at` timestamp NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;');

        $this->execute('ALTER TABLE `repo`
  ADD PRIMARY KEY (`id`);');

        $this->execute('ALTER TABLE `repo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('repo');
        $this->dropTable('user');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210811_080221_create_tables cannot be reverted.\n";

        return false;
    }
    */
}
