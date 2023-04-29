<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429220650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_rec (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id_role INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id_role)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE categorie_reclamation');
        $this->addSql('ALTER TABLE avis ADD idportfolio INT DEFAULT NULL, ADD iduser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0D7F6B997 FOREIGN KEY (idportfolio) REFERENCES portfolio (idportfolio)');
        $this->addSql('CREATE INDEX idportfolio ON avis (idportfolio)');
        $this->addSql('ALTER TABLE facture MODIFY idfacture INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON facture');
        $this->addSql('ALTER TABLE facture ADD cardnumber VARCHAR(50) NOT NULL, ADD expirationdate VARCHAR(5) NOT NULL, ADD securitycode INT NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD total DOUBLE PRECISION NOT NULL, ADD iduser INT DEFAULT NULL, CHANGE idfacture idfac INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD PRIMARY KEY (idfac)');
        $this->addSql('ALTER TABLE panier ADD nom VARCHAR(255) NOT NULL, ADD idprojet INT NOT NULL, ADD qnt INT NOT NULL, ADD iduser INT DEFAULT NULL, CHANGE total prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE portfolio ADD iduser INT DEFAULT NULL, ADD idprojet INT DEFAULT NULL, ADD rating VARCHAR(255) DEFAULT NULL, CHANGE cv cv BLOB NOT NULL');
        $this->addSql('ALTER TABLE projet ADD category_id INT DEFAULT NULL, DROP description, DROP dateprojet');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA912469DE2 FOREIGN KEY (category_id) REFERENCES categorie (idcat)');
        $this->addSql('CREATE INDEX IDX_50159CA912469DE2 ON projet (category_id)');
        $this->addSql('ALTER TABLE reclamation ADD type INT DEFAULT NULL, ADD iduser INT DEFAULT NULL, ADD daterec DATE NOT NULL, ADD titre VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064048CDE5729 FOREIGN KEY (type) REFERENCES categorie_rec (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064045E5C27E9 FOREIGN KEY (iduser) REFERENCES utilisateur (iduser)');
        $this->addSql('CREATE INDEX fkuserrec ON reclamation (iduser)');
        $this->addSql('CREATE INDEX fktyperec ON reclamation (type)');
        $this->addSql('ALTER TABLE utilisateur ADD age DATE DEFAULT NULL, ADD passwd VARCHAR(250) DEFAULT NULL, ADD id_role INT DEFAULT NULL, ADD sexe VARCHAR(55) NOT NULL, ADD image VARCHAR(250) DEFAULT NULL, ADD fa_secret_key VARCHAR(255) DEFAULT NULL, ADD is2fa_enabled TINYINT(1) DEFAULT NULL, DROP role, CHANGE nom nom VARCHAR(50) DEFAULT NULL, CHANGE prenom prenom VARCHAR(50) DEFAULT NULL, CHANGE email email VARCHAR(50) DEFAULT NULL, CHANGE tel tel VARCHAR(50) DEFAULT NULL, CHANGE adresse adresse VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064048CDE5729');
        $this->addSql('CREATE TABLE categorie_reclamation (nom_rec VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(nom_rec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE categorie_rec');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0D7F6B997');
        $this->addSql('DROP INDEX idportfolio ON avis');
        $this->addSql('ALTER TABLE avis DROP idportfolio, DROP iduser');
        $this->addSql('ALTER TABLE facture MODIFY idfac INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON facture');
        $this->addSql('ALTER TABLE facture DROP cardnumber, DROP expirationdate, DROP securitycode, DROP firstname, DROP lastname, DROP total, DROP iduser, CHANGE idfac idfacture INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD PRIMARY KEY (idfacture)');
        $this->addSql('ALTER TABLE panier DROP nom, DROP idprojet, DROP qnt, DROP iduser, CHANGE prix total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE portfolio DROP iduser, DROP idprojet, DROP rating, CHANGE cv cv VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA912469DE2');
        $this->addSql('DROP INDEX IDX_50159CA912469DE2 ON projet');
        $this->addSql('ALTER TABLE projet ADD description VARCHAR(255) NOT NULL, ADD dateprojet DATE NOT NULL, DROP category_id');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064045E5C27E9');
        $this->addSql('DROP INDEX fkuserrec ON reclamation');
        $this->addSql('DROP INDEX fktyperec ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP type, DROP iduser, DROP daterec, DROP titre');
        $this->addSql('ALTER TABLE utilisateur ADD role VARCHAR(255) NOT NULL, DROP age, DROP passwd, DROP id_role, DROP sexe, DROP image, DROP fa_secret_key, DROP is2fa_enabled, CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(150) NOT NULL, CHANGE tel tel VARCHAR(15) NOT NULL, CHANGE adresse adresse VARCHAR(150) NOT NULL');
    }
}
