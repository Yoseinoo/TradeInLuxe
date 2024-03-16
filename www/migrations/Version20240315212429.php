<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315212429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `app_article` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, categorie_id INT NOT NULL, produit_id INT NOT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT NOT NULL, etat VARCHAR(180) NOT NULL, composition LONGTEXT NOT NULL, is_enabled TINYINT(1) NOT NULL, is_validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EF678E2BA76ED395 (user_id), INDEX IDX_EF678E2BBCF5E72D (categorie_id), INDEX IDX_EF678E2BF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_image` (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, reference INT NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_produit` (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4F86C6ABCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2BA76ED395 FOREIGN KEY (user_id) REFERENCES `app_user` (id)');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES `app_categorie` (id)');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2BF347EFB FOREIGN KEY (produit_id) REFERENCES `app_produit` (id)');
        $this->addSql('ALTER TABLE `app_produit` ADD CONSTRAINT FK_C4F86C6ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES `app_categorie` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2BA76ED395');
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2BBCF5E72D');
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2BF347EFB');
        $this->addSql('ALTER TABLE `app_produit` DROP FOREIGN KEY FK_C4F86C6ABCF5E72D');
        $this->addSql('DROP TABLE `app_article`');
        $this->addSql('DROP TABLE `app_image`');
        $this->addSql('DROP TABLE `app_produit`');
    }
}
