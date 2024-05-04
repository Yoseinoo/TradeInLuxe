<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504165727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `app_favoris` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_646E447FA76ED395 (user_id), INDEX IDX_646E447FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `app_favoris` ADD CONSTRAINT FK_646E447FA76ED395 FOREIGN KEY (user_id) REFERENCES `app_user` (id)');
        $this->addSql('ALTER TABLE `app_favoris` ADD CONSTRAINT FK_646E447FF347EFB FOREIGN KEY (produit_id) REFERENCES `app_produit` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `app_favoris` DROP FOREIGN KEY FK_646E447FA76ED395');
        $this->addSql('ALTER TABLE `app_favoris` DROP FOREIGN KEY FK_646E447FF347EFB');
        $this->addSql('DROP TABLE `app_favoris`');
    }
}
