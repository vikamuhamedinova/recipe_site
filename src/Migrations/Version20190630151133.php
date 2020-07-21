<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190630151133 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name_category VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composition (id INT AUTO_INCREMENT NOT NULL, id_dimension_id INT NOT NULL, id_ingredient_id INT NOT NULL, id_recipe_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_C7F43474B55DDF (id_dimension_id), INDEX IDX_C7F43472D1731E9 (id_ingredient_id), INDEX IDX_C7F4347D9ED1E33 (id_recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension (id INT AUTO_INCREMENT NOT NULL, name_dimension VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name_ingredient VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, id_recipe_id INT NOT NULL, number INT NOT NULL, content LONGTEXT NOT NULL, photo VARCHAR(50) DEFAULT NULL, INDEX IDX_B1BDD6CBD9ED1E33 (id_recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, id_category_id INT NOT NULL, name_recipe VARCHAR(250) NOT NULL, portion INT NOT NULL, time INT NOT NULL, INDEX IDX_DA88B137A545015 (id_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F43474B55DDF FOREIGN KEY (id_dimension_id) REFERENCES dimension (id)');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F43472D1731E9 FOREIGN KEY (id_ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE composition ADD CONSTRAINT FK_C7F4347D9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CBD9ED1E33 FOREIGN KEY (id_recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137A545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137A545015');
        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F43474B55DDF');
        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F43472D1731E9');
        $this->addSql('ALTER TABLE composition DROP FOREIGN KEY FK_C7F4347D9ED1E33');
        $this->addSql('ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CBD9ED1E33');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE dimension');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE phase');
        $this->addSql('DROP TABLE recipe');
    }
}
