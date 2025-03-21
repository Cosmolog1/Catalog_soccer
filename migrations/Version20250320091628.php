<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320091628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club_category (club_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5F7B36861190A32 (club_id), INDEX IDX_5F7B36812469DE2 (category_id), PRIMARY KEY(club_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club_category ADD CONSTRAINT FK_5F7B36861190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE club_category ADD CONSTRAINT FK_5F7B36812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club_category DROP FOREIGN KEY FK_5F7B36861190A32');
        $this->addSql('ALTER TABLE club_category DROP FOREIGN KEY FK_5F7B36812469DE2');
        $this->addSql('DROP TABLE club_category');
    }
}
