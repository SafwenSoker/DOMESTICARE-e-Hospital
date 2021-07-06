<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210608182325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting ADD medecin_id INT NOT NULL, ADD patient_id INT NOT NULL, ADD snd_id INT NOT NULL');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E1394F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E1396B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_F515E1394F31A84 ON meeting (medecin_id)');
        $this->addSql('CREATE INDEX IDX_F515E1396B899279 ON meeting (patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E1394F31A84');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E1396B899279');
        $this->addSql('DROP INDEX IDX_F515E1394F31A84 ON meeting');
        $this->addSql('DROP INDEX IDX_F515E1396B899279 ON meeting');
        $this->addSql('ALTER TABLE meeting DROP medecin_id, DROP patient_id, DROP snd_id');
    }
}
