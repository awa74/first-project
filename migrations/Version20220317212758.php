<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317212758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, d_eri_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, examiner VARCHAR(255) DEFAULT NULL, valider VARCHAR(255) DEFAULT NULL, recuser VARCHAR(255) DEFAULT NULL, INDEX IDX_2694D7A5DDEAB1A3 (etudiant_id), INDEX IDX_2694D7A5E01B619B (d_eri_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, INDEX IDX_3D48E037DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, d_eri_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, texte VARCHAR(255) DEFAULT NULL, date VARCHAR(255) NOT NULL, heur VARCHAR(255) DEFAULT NULL, INDEX IDX_B6BD307FE01B619B (d_eri_id), INDEX IDX_B6BD307FDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, telephone INT DEFAULT NULL, photo LONGBLOB DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5E01B619B FOREIGN KEY (d_eri_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE01B619B FOREIGN KEY (d_eri_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5DDEAB1A3');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5E01B619B');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037DDEAB1A3');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE01B619B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FDDEAB1A3');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE `user`');
    }
}
