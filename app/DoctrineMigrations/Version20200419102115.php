<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200419102115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_7882EFEFA77FBEAF');
        $this->addSql('CREATE TABLE Comment (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5BC96BF0A77FBEAF (blog_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_FAB8C3B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Comment ADD CONSTRAINT FK_5BC96BF0A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES Post (id)');
        $this->addSql('ALTER TABLE Post ADD CONSTRAINT FK_FAB8C3B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE post');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Comment DROP FOREIGN KEY FK_5BC96BF0A77FBEAF');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, INDEX IDX_7882EFEFA77FBEAF (blog_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, INDEX IDX_BA5AE01DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_7882EFEFA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_BA5AE01DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE Comment');
        $this->addSql('DROP TABLE Post');
    }
}
