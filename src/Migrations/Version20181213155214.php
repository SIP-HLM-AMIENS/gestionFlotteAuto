<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213155214 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pointage_mobile (id INT AUTO_INCREMENT NOT NULL, id_pointage INT NOT NULL, id_tag_voiture VARCHAR(255) NOT NULL, depart TINYINT(1) NOT NULL, kilometrage INT NOT NULL, heure_depart VARCHAR(255) NOT NULL, heure_arrivee VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, motif VARCHAR(255) NOT NULL, position_parking VARCHAR(255) NOT NULL, utilisateur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateurs CHANGE service_id service_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE service_id service_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage CHANGE reservation_id reservation_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pointage_mobile');
        $this->addSql('ALTER TABLE pointage CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE service_id service_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE voiture CHANGE service_id service_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
