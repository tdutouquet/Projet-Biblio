<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419155934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, livres_id INT NOT NULL, user_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, date_rendu DATETIME DEFAULT NULL, extension TINYINT(1) NOT NULL, INDEX IDX_364071D7EBF07F38 (livres_id), INDEX IDX_364071D7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements_salles (equipements_id INT NOT NULL, salles_id INT NOT NULL, INDEX IDX_25FA9FE3852CCFF5 (equipements_id), INDEX IDX_25FA9FE3B11E4946 (salles_id), PRIMARY KEY(equipements_id, salles_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livres (id INT AUTO_INCREMENT NOT NULL, etat_id INT NOT NULL, titre VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, annee_publication INT NOT NULL, maison_edition VARCHAR(255) NOT NULL, resume VARCHAR(255) NOT NULL, image LONGBLOB NOT NULL, categorie VARCHAR(255) NOT NULL, disponibilite TINYINT(1) NOT NULL, note INT NOT NULL, INDEX IDX_927187A4D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, capacite NUMERIC(10, 0) NOT NULL, disponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, subscription_type_id INT DEFAULT NULL, user_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A3C664D3B6596C08 (subscription_type_id), INDEX IDX_A3C664D3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(150) NOT NULL, phone VARCHAR(10) NOT NULL, birthdate DATE NOT NULL, is_banned TINYINT(1) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7EBF07F38 FOREIGN KEY (livres_id) REFERENCES livres (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE equipements_salles ADD CONSTRAINT FK_25FA9FE3852CCFF5 FOREIGN KEY (equipements_id) REFERENCES equipements (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipements_salles ADD CONSTRAINT FK_25FA9FE3B11E4946 FOREIGN KEY (salles_id) REFERENCES salles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livres ADD CONSTRAINT FK_927187A4D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3B6596C08 FOREIGN KEY (subscription_type_id) REFERENCES subscription_type (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7EBF07F38');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7A76ED395');
        $this->addSql('ALTER TABLE equipements_salles DROP FOREIGN KEY FK_25FA9FE3852CCFF5');
        $this->addSql('ALTER TABLE equipements_salles DROP FOREIGN KEY FK_25FA9FE3B11E4946');
        $this->addSql('ALTER TABLE livres DROP FOREIGN KEY FK_927187A4D5E86FF');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3B6596C08');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE equipements');
        $this->addSql('DROP TABLE equipements_salles');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE livres');
        $this->addSql('DROP TABLE salles');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
