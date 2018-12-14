<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181214110228 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateurs CHANGE service_id service_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE service_id service_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage ADD utilisateur_id INT DEFAULT NULL, ADD voiture_id INT DEFAULT NULL, CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE pointage ADD CONSTRAINT FK_7591B20181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_7591B20FB88E14F ON pointage (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_7591B20181A8BA ON pointage (voiture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20FB88E14F');
        $this->addSql('ALTER TABLE pointage DROP FOREIGN KEY FK_7591B20181A8BA');
        $this->addSql('DROP INDEX IDX_7591B20FB88E14F ON pointage');
        $this->addSql('DROP INDEX IDX_7591B20181A8BA ON pointage');
        $this->addSql('ALTER TABLE pointage DROP utilisateur_id, DROP voiture_id, CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE personne_id personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs CHANGE service_id service_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE voiture CHANGE service_id service_id INT DEFAULT NULL, CHANGE responsable_id responsable_id INT DEFAULT NULL');
    }
}
