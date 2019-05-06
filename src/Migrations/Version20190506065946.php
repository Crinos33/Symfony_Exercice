<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190506065946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listitem ADD tasklist_id INT NOT NULL');
        $this->addSql('ALTER TABLE listitem ADD CONSTRAINT FK_43F3A0C9FF3475DB FOREIGN KEY (tasklist_id) REFERENCES tasklist (id)');
        $this->addSql('CREATE INDEX IDX_43F3A0C9FF3475DB ON listitem (tasklist_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE listitem DROP FOREIGN KEY FK_43F3A0C9FF3475DB');
        $this->addSql('DROP INDEX IDX_43F3A0C9FF3475DB ON listitem');
        $this->addSql('ALTER TABLE listitem DROP tasklist_id');
    }
}
