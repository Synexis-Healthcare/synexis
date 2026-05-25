<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260513111553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create laboratory_dictionary.specimen_definitions table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE laboratory_dictionary.specimen_definitions (
                      id UUID NOT NULL,
                      biomaterial TEXT NOT NULL,
                      filler TEXT,
                      temperature_condition TEXT,
                      stability_period TEXT,
                      preparation_requirements TEXT,
                      container_id UUID NOT NULL,
                      PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_6E1712C4BC21F742 ON laboratory_dictionary.specimen_definitions (container_id)');

        $this->addSql('ALTER TABLE laboratory_dictionary.specimen_definitions ADD CONSTRAINT FK_6E1712C4BC21F742 FOREIGN KEY (container_id) REFERENCES laboratory_dictionary.containers (id) NOT DEFERRABLE');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE laboratory_dictionary.specimen_definitions DROP CONSTRAINT FK_6E1712C4BC21F742');
        $this->addSql('DROP TABLE laboratory_dictionary.specimen_definitions');
    }
}
