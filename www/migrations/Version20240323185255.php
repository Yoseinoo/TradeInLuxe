<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323185255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_produit DROP FOREIGN KEY FK_C4F86C6A3DA5256D');
        $this->addSql('ALTER TABLE app_article DROP FOREIGN KEY FK_EF678E2B3DA5256D');
        $this->addSql('DROP TABLE app_image');
        $this->addSql('DROP INDEX IDX_EF678E2B3DA5256D ON app_article');
        $this->addSql('ALTER TABLE app_article ADD path_image VARCHAR(255) DEFAULT NULL, DROP image_id');
        $this->addSql('DROP INDEX IDX_C4F86C6A3DA5256D ON app_produit');
        $this->addSql('ALTER TABLE app_produit ADD path_image VARCHAR(255) DEFAULT NULL, DROP image_id');
        $this->addSql('ALTER TABLE app_user ADD path_image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `app_produit` ADD image_id INT DEFAULT NULL, DROP path_image');
        $this->addSql('ALTER TABLE `app_produit` ADD CONSTRAINT FK_C4F86C6A3DA5256D FOREIGN KEY (image_id) REFERENCES app_image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C4F86C6A3DA5256D ON `app_produit` (image_id)');
        $this->addSql('ALTER TABLE `app_article` ADD image_id INT DEFAULT NULL, DROP path_image');
        $this->addSql('ALTER TABLE `app_article` ADD CONSTRAINT FK_EF678E2B3DA5256D FOREIGN KEY (image_id) REFERENCES app_image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EF678E2B3DA5256D ON `app_article` (image_id)');
        $this->addSql('ALTER TABLE `app_user` DROP path_image');
    }
}
