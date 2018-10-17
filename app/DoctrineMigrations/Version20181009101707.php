<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181009101707 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE designation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attendance (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, date DATE NOT NULL, time_in TIME NOT NULL, time_out TIME NOT NULL, INDEX IDX_6DE30D918C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, designation_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, salary VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_BA82C300E7927C74 (email), INDEX IDX_BA82C300AE80F5DF (department_id), INDEX IDX_BA82C300FAC7D83F (designation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_employees (employees_source INT NOT NULL, employees_target INT NOT NULL, INDEX IDX_E34FCFD9882CB9E6 (employees_source), INDEX IDX_E34FCFD991C9E969 (employees_target), PRIMARY KEY(employees_source, employees_target)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D918C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employees_employees ADD CONSTRAINT FK_E34FCFD9882CB9E6 FOREIGN KEY (employees_source) REFERENCES employees (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employees_employees ADD CONSTRAINT FK_E34FCFD991C9E969 FOREIGN KEY (employees_target) REFERENCES employees (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300FAC7D83F');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300AE80F5DF');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D918C03F15C');
        $this->addSql('ALTER TABLE employees_employees DROP FOREIGN KEY FK_E34FCFD9882CB9E6');
        $this->addSql('ALTER TABLE employees_employees DROP FOREIGN KEY FK_E34FCFD991C9E969');
        $this->addSql('DROP TABLE designation');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE employees_employees');
    }
}
