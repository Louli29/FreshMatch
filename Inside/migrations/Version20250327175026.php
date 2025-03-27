<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250327175026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_ingredient_recipe DROP FOREIGN KEY FK_E4BB99D253AA0A63');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe DROP FOREIGN KEY FK_E4BB99D259D8A214');
        $this->addSql('DROP TABLE recipe_ingredient_recipe');
        $this->addSql('ALTER TABLE ingredient ADD season JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient_recipe ADD recipe_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredient_recipe ADD CONSTRAINT FK_36F27176933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE ingredient_recipe ADD CONSTRAINT FK_36F2717659D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('CREATE INDEX IDX_36F2717659D8A214 ON ingredient_recipe (recipe_id)');
        $this->addSql('ALTER TABLE recipe CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_ingredient_recipe (recipe_id INT NOT NULL, ingredient_recipe_id INT NOT NULL, INDEX IDX_E4BB99D253AA0A63 (ingredient_recipe_id), INDEX IDX_E4BB99D259D8A214 (recipe_id), PRIMARY KEY(recipe_id, ingredient_recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe ADD CONSTRAINT FK_E4BB99D253AA0A63 FOREIGN KEY (ingredient_recipe_id) REFERENCES ingredient_recipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe ADD CONSTRAINT FK_E4BB99D259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient_recipe DROP FOREIGN KEY FK_36F27176933FE08C');
        $this->addSql('ALTER TABLE ingredient_recipe DROP FOREIGN KEY FK_36F2717659D8A214');
        $this->addSql('DROP INDEX IDX_36F2717659D8A214 ON ingredient_recipe');
        $this->addSql('ALTER TABLE ingredient_recipe DROP recipe_id');
        $this->addSql('ALTER TABLE ingredient DROP season');
    }
}
