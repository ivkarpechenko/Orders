<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705150319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP user_name');
        $this->addSql('ALTER TABLE "order" DROP parent_id');
        $this->addSql('ALTER TABLE "order" DROP sum_volume');
        $this->addSql('ALTER TABLE "order" DROP sum_weight');
        $this->addSql('ALTER TABLE "order" ALTER status SET DEFAULT \'Created\'');
        $this->addSql('ALTER TABLE "order" ALTER created_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN logistics_name TO company_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" ADD user_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ADD sum_volume INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ADD sum_weight INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ALTER status SET DEFAULT \'Создан\'');
        $this->addSql('ALTER TABLE "order" ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE "order" ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN company_name TO logistics_name');
    }
}
