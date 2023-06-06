<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606123328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery ADD service_id INT DEFAULT NULL, DROP type, DROP type_id');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_472B783AED5CA9E6 ON gallery (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AED5CA9E6');
        $this->addSql('DROP INDEX IDX_472B783AED5CA9E6 ON gallery');
        $this->addSql('ALTER TABLE gallery ADD type VARCHAR(150) NOT NULL, ADD type_id INT NOT NULL, DROP service_id');
    }
}
