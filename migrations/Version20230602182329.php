<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602182329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_order CHANGE booking_table_id booking_table_id INT NOT NULL');
        $this->addSql('ALTER TABLE booking_order ADD CONSTRAINT FK_64556E2DD7CBB6D1 FOREIGN KEY (booking_table_id) REFERENCES booking_table (id)');
        $this->addSql('CREATE INDEX IDX_64556E2DD7CBB6D1 ON booking_order (booking_table_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_order DROP FOREIGN KEY FK_64556E2DD7CBB6D1');
        $this->addSql('DROP INDEX IDX_64556E2DD7CBB6D1 ON booking_order');
        $this->addSql('ALTER TABLE booking_order CHANGE booking_table_id booking_table_id VARCHAR(255) NOT NULL');
    }
}
