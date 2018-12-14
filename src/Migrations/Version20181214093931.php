<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181214093931 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateurs CHANGE service_id service_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage_mobile ADD email VARCHAR(255) NOT NULL, ADD immatriculation VARCHAR(255) NOT NULL, DROP id_tag_voiture, DROP utilisateur');
        $this->addSql('ALTER TABLE voiture CHANGE service_id service_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage CHANGE reservation_id reservation_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pointage CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage_mobile ADD id_tag_voiture VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD utilisateur VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP email, DROP immatriculation');
        $this->addSql('ALTER TABLE reservation CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE service_id service_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE voiture CHANGE service_id service_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
