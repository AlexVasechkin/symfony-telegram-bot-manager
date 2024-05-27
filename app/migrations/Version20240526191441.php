<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526191441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE telegram_bot_message (id UUID NOT NULL, message_id BIGINT NOT NULL, data JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, processed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_processed BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX ix__is_processed ON telegram_bot_message (is_processed)');
        $this->addSql('CREATE UNIQUE INDEX ix_uq__message_id ON telegram_bot_message (message_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE telegram_bot_message');
    }
}
