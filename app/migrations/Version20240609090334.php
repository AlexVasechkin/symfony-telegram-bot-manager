<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609090334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE telegram_bot_message ADD message_id BIGINT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE INDEX IDX_F9C9D5C9537A1329 ON telegram_bot_message (message_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_F9C9D5C9537A1329');
        $this->addSql('ALTER TABLE telegram_bot_message DROP message_id');
    }
}
