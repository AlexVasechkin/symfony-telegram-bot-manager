<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609144506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE telegram_bot_message_event_action (id BIGINT GENERATED BY DEFAULT AS IDENTITY NOT NULL, event VARCHAR(100) NOT NULL, action VARCHAR(100) NOT NULL, telegram_bot_message_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47DED067E6C82348 ON telegram_bot_message_event_action (telegram_bot_message_id)');
        $this->addSql('CREATE INDEX IDX_47DED067E6C823483BAE0AA747CC8C92 ON telegram_bot_message_event_action (telegram_bot_message_id, event, action)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE telegram_bot_message_event_action');
    }
}