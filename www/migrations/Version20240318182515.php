<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318182515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_image ADD reference_produit_id INT DEFAULT NULL, ADD reference_article_id INT DEFAULT NULL, DROP reference');
        $this->addSql('ALTER TABLE app_image ADD CONSTRAINT FK_13EE89925B2A4BB4 FOREIGN KEY (reference_produit_id) REFERENCES `app_produit` (id)');
        $this->addSql('ALTER TABLE app_image ADD CONSTRAINT FK_13EE8992268AB3D3 FOREIGN KEY (reference_article_id) REFERENCES `app_article` (id)');
        $this->addSql('CREATE INDEX IDX_13EE89925B2A4BB4 ON app_image (reference_produit_id)');
        $this->addSql('CREATE INDEX IDX_13EE8992268AB3D3 ON app_image (reference_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `app_image` DROP FOREIGN KEY FK_13EE89925B2A4BB4');
        $this->addSql('ALTER TABLE `app_image` DROP FOREIGN KEY FK_13EE8992268AB3D3');
        $this->addSql('DROP INDEX IDX_13EE89925B2A4BB4 ON `app_image`');
        $this->addSql('DROP INDEX IDX_13EE8992268AB3D3 ON `app_image`');
        $this->addSql('ALTER TABLE `app_image` ADD reference INT NOT NULL, DROP reference_produit_id, DROP reference_article_id');
    }
}
