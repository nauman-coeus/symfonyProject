<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181024071126 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE employee (id INT UNSIGNED AUTO_INCREMENT NOT NULL, department_id INT UNSIGNED DEFAULT NULL, designation_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, salary INT UNSIGNED DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), INDEX IDX_5D9F75A1AE80F5DF (department_id), INDEX IDX_5D9F75A1FAC7D83F (designation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_employee (employee_source INT UNSIGNED NOT NULL, employee_target INT UNSIGNED NOT NULL, INDEX IDX_CDA0246676BBBBE6 (employee_source), INDEX IDX_CDA024666F5EEB69 (employee_target), PRIMARY KEY(employee_source, employee_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attendance (id INT UNSIGNED AUTO_INCREMENT NOT NULL, employee_id INT UNSIGNED DEFAULT NULL, status VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, time_in VARCHAR(255) NOT NULL, time_out VARCHAR(255) DEFAULT NULL, INDEX IDX_6DE30D918C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_employee ADD CONSTRAINT FK_CDA0246676BBBBE6 FOREIGN KEY (employee_source) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_employee ADD CONSTRAINT FK_CDA024666F5EEB69 FOREIGN KEY (employee_target) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D918C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee_employee DROP FOREIGN KEY FK_CDA0246676BBBBE6');
        $this->addSql('ALTER TABLE employee_employee DROP FOREIGN KEY FK_CDA024666F5EEB69');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D918C03F15C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1FAC7D83F');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1AE80F5DF');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_employee');
        $this->addSql('DROP TABLE designation');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE department');
    }
}
