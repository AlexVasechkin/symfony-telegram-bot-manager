<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240606145933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE telegram_bot_update ADD chat_id INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE telegram_bot_update ADD payload VARCHAR(8000) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_3332D1DB1A9A7125 ON telegram_bot_update (chat_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_3332D1DB1A9A7125');
        $this->addSql('ALTER TABLE telegram_bot_update DROP chat_id');
        $this->addSql('ALTER TABLE telegram_bot_update DROP payload');
    }
}
