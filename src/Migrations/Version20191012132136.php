<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191012132136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7717AF4CB');
        $this->addSql('DROP INDEX IDX_A4D707F7717AF4CB ON reaction');
        $this->addSql('ALTER TABLE reaction CHANGE camp_id_id camp_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reaction CHANGE camp_id camp_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7717AF4CB FOREIGN KEY (camp_id_id) REFERENCES camp (id)');
        $this->addSql('CREATE INDEX IDX_A4D707F7717AF4CB ON reaction (camp_id_id)');
    }
}
