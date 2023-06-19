<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618182341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_balance DROP FOREIGN KEY FK_65DF0BB6727ACA70');
        $this->addSql('ALTER TABLE account_balance ADD CONSTRAINT FK_65DF0BB6727ACA70 FOREIGN KEY (parent_id) REFERENCES account_balance (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_balance DROP FOREIGN KEY FK_65DF0BB6727ACA70');
        $this->addSql('ALTER TABLE account_balance ADD CONSTRAINT FK_65DF0BB6727ACA70 FOREIGN KEY (parent_id) REFERENCES account_balance (id)');
    }
}
