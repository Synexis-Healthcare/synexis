<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260513153346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create laboratory_dictionary.test_categories table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE laboratory_dictionary.test_categories (
               mnemonic TEXT NOT NULL,
               title TEXT NOT NULL,
               PRIMARY KEY (mnemonic))');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_4269ABC32B36786B ON laboratory_dictionary.test_categories (title)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE laboratory_dictionary.test_categories');
    }
}
