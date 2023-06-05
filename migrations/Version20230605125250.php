<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605125250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, type_id INT NOT NULL, type VARCHAR(150) NOT NULL, INDEX IDX_472B783AC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, featured_image VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_order ADD customer_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(15) NOT NULL, ADD persons INT NOT NULL, ADD notes VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE booking_table ADD capacity INT NOT NULL');
        $this->addSql('ALTER TABLE menu_item ADD price_1 DOUBLE PRECISION NOT NULL, ADD price_2 DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE services');
        $this->addSql('ALTER TABLE booking_table DROP capacity');
        $this->addSql('ALTER TABLE booking_order DROP customer_name, DROP email, DROP phone, DROP persons, DROP notes');
        $this->addSql('ALTER TABLE menu_item DROP price_1, DROP price_2');
    }
}
