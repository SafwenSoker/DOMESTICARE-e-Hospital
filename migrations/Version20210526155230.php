<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526155230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, maladie_id INT NOT NULL, nombre_votes INT NOT NULL, INDEX IDX_67F068BC6B899279 (patient_id), INDEX IDX_67F068BCB4B1C397 (maladie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_medecin (id INT AUTO_INCREMENT NOT NULL, medecin_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A3BD6F90E7927C74 (email), UNIQUE INDEX UNIQ_A3BD6F904F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_patient (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A2BDEBBDE7927C74 (email), UNIQUE INDEX UNIQ_A2BDEBBD6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_rv (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, medecin_id INT NOT NULL, INDEX IDX_DA66E4CA6B899279 (patient_id), INDEX IDX_DA66E4CA4F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hopital (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maladie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, cause LONGTEXT NOT NULL, symptome LONGTEXT NOT NULL, traitement LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_embauche DATE NOT NULL, numero_telephone INT NOT NULL, matricule VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numero_telephone INT NOT NULL, photo VARCHAR(255) NOT NULL, cin INT NOT NULL, adresse LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCB4B1C397 FOREIGN KEY (maladie_id) REFERENCES maladie (id)');
        $this->addSql('ALTER TABLE compte_medecin ADD CONSTRAINT FK_A3BD6F904F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE compte_patient ADD CONSTRAINT FK_A2BDEBBD6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE demande_rv ADD CONSTRAINT FK_DA66E4CA6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE demande_rv ADD CONSTRAINT FK_DA66E4CA4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCB4B1C397');
        $this->addSql('ALTER TABLE compte_medecin DROP FOREIGN KEY FK_A3BD6F904F31A84');
        $this->addSql('ALTER TABLE demande_rv DROP FOREIGN KEY FK_DA66E4CA4F31A84');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC6B899279');
        $this->addSql('ALTER TABLE compte_patient DROP FOREIGN KEY FK_A2BDEBBD6B899279');
        $this->addSql('ALTER TABLE demande_rv DROP FOREIGN KEY FK_DA66E4CA6B899279');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE compte_medecin');
        $this->addSql('DROP TABLE compte_patient');
        $this->addSql('DROP TABLE demande_rv');
        $this->addSql('DROP TABLE hopital');
        $this->addSql('DROP TABLE maladie');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
    }
}
