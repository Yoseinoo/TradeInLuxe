<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323181614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `app_article` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, categorie_id INT NOT NULL, produit_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT NOT NULL, etat VARCHAR(180) NOT NULL, composition LONGTEXT NOT NULL, is_enabled TINYINT(1) NOT NULL, is_validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EF678E2BA76ED395 (user_id), INDEX IDX_EF678E2BBCF5E72D (categorie_id), INDEX IDX_EF678E2BF347EFB (produit_id), INDEX IDX_EF678E2B3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_categorie` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_image` (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_produit` (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(180) NOT NULL, description LONGTEXT NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4F86C6ABCF5E72D (categorie_id), INDEX IDX_C4F86C6A3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_reset_password_request` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2AD4C710A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_subject_contact` (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `app_user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, firstname VARCHAR(25) DEFAULT NULL, lastname VARCHAR(25) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', street VARCHAR(180) DEFAULT NULL, postcode VARCHAR(8) DEFAULT NULL, city VARCHAR(180) DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_88BDF3E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2BA76ED395 FOREIGN KEY (user_id) REFERENCES `app_user` (id)');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES `app_categorie` (id)');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2BF347EFB FOREIGN KEY (produit_id) REFERENCES `app_produit` (id)');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2B3DA5256D FOREIGN KEY (image_id) REFERENCES `app_image` (id)');
        $this->addSql('ALTER TABLE `app_produit` ADD CONSTRAINT FK_C4F86C6ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES `app_categorie` (id)');
        $this->addSql('ALTER TABLE `app_produit` ADD CONSTRAINT FK_C4F86C6A3DA5256D FOREIGN KEY (image_id) REFERENCES `app_image` (id)');
        $this->addSql('ALTER TABLE `app_reset_password_request` ADD CONSTRAINT FK_2AD4C710A76ED395 FOREIGN KEY (user_id) REFERENCES `app_user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2BA76ED395');
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2BBCF5E72D');
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2BF347EFB');
        $this->addSql('ALTER TABLE `app_article` DROP FOREIGN KEY FK_EF678E2B3DA5256D');
        $this->addSql('ALTER TABLE `app_produit` DROP FOREIGN KEY FK_C4F86C6ABCF5E72D');
        $this->addSql('ALTER TABLE `app_produit` DROP FOREIGN KEY FK_C4F86C6A3DA5256D');
        $this->addSql('ALTER TABLE `app_reset_password_request` DROP FOREIGN KEY FK_2AD4C710A76ED395');
        $this->addSql('DROP TABLE `app_article`');
        $this->addSql('DROP TABLE `app_categorie`');
        $this->addSql('DROP TABLE `app_image`');
        $this->addSql('DROP TABLE `app_produit`');
        $this->addSql('DROP TABLE `app_reset_password_request`');
        $this->addSql('DROP TABLE `app_subject_contact`');
        $this->addSql('DROP TABLE `app_user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
