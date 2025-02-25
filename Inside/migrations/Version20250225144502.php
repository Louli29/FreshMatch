<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225144502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_ingr_user DROP FOREIGN KEY FK_800B125DA76ED395');
        $this->addSql('DROP INDEX UNIQ_800B125DA76ED395 ON list_ingr_user');
        $this->addSql('ALTER TABLE list_ingr_user DROP user_id');
        $this->addSql('ALTER TABLE recipe CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD list_ingredient_id INT DEFAULT NULL, ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, DROP mail');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491920CC85 FOREIGN KEY (list_ingredient_id) REFERENCES list_ingr_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491920CC85 ON user (list_ingredient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491920CC85');
        $this->addSql('DROP INDEX UNIQ_8D93D6491920CC85 ON user');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user ADD mail VARCHAR(255) NOT NULL, DROP list_ingredient_id, DROP email, DROP roles');
        $this->addSql('ALTER TABLE recipe CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE list_ingr_user ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE list_ingr_user ADD CONSTRAINT FK_800B125DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_800B125DA76ED395 ON list_ingr_user (user_id)');
    }
}
