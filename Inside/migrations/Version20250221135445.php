<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221135445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type_ingredient VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient_recipe (id INT AUTO_INCREMENT NOT NULL, ingredient_id INT NOT NULL, quantity INT NOT NULL, remplacable TINYINT(1) NOT NULL, unite VARCHAR(50) NOT NULL, INDEX IDX_36F27176933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_ingr_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_800B125DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_ingr_user_ingredient (list_ingr_user_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_49FB52F9ED03D108 (list_ingr_user_id), INDEX IDX_49FB52F9933FE08C (ingredient_id), PRIMARY KEY(list_ingr_user_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, time INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, step VARCHAR(255) NOT NULL, nb_person INT NOT NULL, allergys LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', diet VARCHAR(255) DEFAULT NULL, image_link VARCHAR(255) NOT NULL, INDEX IDX_DA88B137A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_ingredient_recipe (recipe_id INT NOT NULL, ingredient_recipe_id INT NOT NULL, INDEX IDX_E4BB99D259D8A214 (recipe_id), INDEX IDX_E4BB99D253AA0A63 (ingredient_recipe_id), PRIMARY KEY(recipe_id, ingredient_recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, allergy LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', diet VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient_recipe ADD CONSTRAINT FK_36F27176933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE list_ingr_user ADD CONSTRAINT FK_800B125DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE list_ingr_user_ingredient ADD CONSTRAINT FK_49FB52F9ED03D108 FOREIGN KEY (list_ingr_user_id) REFERENCES list_ingr_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE list_ingr_user_ingredient ADD CONSTRAINT FK_49FB52F9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe ADD CONSTRAINT FK_E4BB99D259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe ADD CONSTRAINT FK_E4BB99D253AA0A63 FOREIGN KEY (ingredient_recipe_id) REFERENCES ingredient_recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient_recipe DROP FOREIGN KEY FK_36F27176933FE08C');
        $this->addSql('ALTER TABLE list_ingr_user DROP FOREIGN KEY FK_800B125DA76ED395');
        $this->addSql('ALTER TABLE list_ingr_user_ingredient DROP FOREIGN KEY FK_49FB52F9ED03D108');
        $this->addSql('ALTER TABLE list_ingr_user_ingredient DROP FOREIGN KEY FK_49FB52F9933FE08C');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137A76ED395');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe DROP FOREIGN KEY FK_E4BB99D259D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient_recipe DROP FOREIGN KEY FK_E4BB99D253AA0A63');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_recipe');
        $this->addSql('DROP TABLE list_ingr_user');
        $this->addSql('DROP TABLE list_ingr_user_ingredient');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_ingredient_recipe');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
