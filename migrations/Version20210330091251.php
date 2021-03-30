<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330091251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Change name of isEnable attribute for posts table';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE enabled is_enable TINYINT(1) DEFAULT \'1\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE is_enable enabled TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}
