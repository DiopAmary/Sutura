<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303212137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cotisation (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, periode INT NOT NULL, date DATETIME NOT NULL, justificatif VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_AE64D2EDDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE declar_remboursement (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, periode INT NOT NULL, type VARCHAR(255) NOT NULL, justificatif VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_57522A0FDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipes (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, pays_origine VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nombre_annee_maroc INT NOT NULL, numero_telephone VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, adressemail_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, pays_origine VARCHAR(255) NOT NULL, nombre_annee_maroc INT NOT NULL, date DATETIME NOT NULL, num_telephone VARCHAR(255) NOT NULL, ville_etude VARCHAR(255) NOT NULL, etablissement VARCHAR(255) NOT NULL, filiere VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_717E22E3FE915D6A (adressemail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE montant (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pret (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, date DATETIME NOT NULL, echeance DATETIME NOT NULL, periode INT NOT NULL, montant DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, rib VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_52ECE979DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_CE606404DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2EDDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE declar_remboursement ADD CONSTRAINT FK_57522A0FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3FE915D6A FOREIGN KEY (adressemail_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE979DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2EDDDEAB1A3');
        $this->addSql('ALTER TABLE declar_remboursement DROP FOREIGN KEY FK_57522A0FDDEAB1A3');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE979DDEAB1A3');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404DDEAB1A3');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3FE915D6A');
        $this->addSql('DROP TABLE cotisation');
        $this->addSql('DROP TABLE declar_remboursement');
        $this->addSql('DROP TABLE equipes');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE montant');
        $this->addSql('DROP TABLE pret');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE user');
    }
}
