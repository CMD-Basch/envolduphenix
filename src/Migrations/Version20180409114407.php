<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409114407 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE round ADD event_type_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA34401B253C FOREIGN KEY (event_type_id) REFERENCES event_type (id)');
        $this->addSql('CREATE INDEX IDX_C5EEEA34401B253C ON round (event_type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA34401B253C');
        $this->addSql('DROP INDEX IDX_C5EEEA34401B253C ON round');
        $this->addSql('ALTER TABLE round ADD type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP event_type_id');
    }
}
