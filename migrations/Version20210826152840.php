<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826152840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_role (project_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_6EF84272166D1F9C (project_id), INDEX IDX_6EF84272D60322AC (role_id), PRIMARY KEY(project_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_uapp (role_id INT NOT NULL, uapp_id INT NOT NULL, INDEX IDX_F53554FBD60322AC (role_id), INDEX IDX_F53554FBEB79A07C (uapp_id), PRIMARY KEY(role_id, uapp_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uapp_bundle (uapp_id INT NOT NULL, bundle_id INT NOT NULL, INDEX IDX_47007856EB79A07C (uapp_id), INDEX IDX_47007856F1FAD9D3 (bundle_id), PRIMARY KEY(uapp_id, bundle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_project (user_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_77BECEE4A76ED395 (user_id), INDEX IDX_77BECEE4166D1F9C (project_id), PRIMARY KEY(user_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_role ADD CONSTRAINT FK_6EF84272166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_role ADD CONSTRAINT FK_6EF84272D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_uapp ADD CONSTRAINT FK_F53554FBD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_uapp ADD CONSTRAINT FK_F53554FBEB79A07C FOREIGN KEY (uapp_id) REFERENCES uapp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uapp_bundle ADD CONSTRAINT FK_47007856EB79A07C FOREIGN KEY (uapp_id) REFERENCES uapp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE uapp_bundle ADD CONSTRAINT FK_47007856F1FAD9D3 FOREIGN KEY (bundle_id) REFERENCES bundle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT FK_77BECEE4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT FK_77BECEE4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bundle ADD interfaces_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bundle ADD CONSTRAINT FK_A57B32FDE46C54C0 FOREIGN KEY (interfaces_id) REFERENCES interfaces (id)');
        $this->addSql('CREATE INDEX IDX_A57B32FDE46C54C0 ON bundle (interfaces_id)');
        $this->addSql('ALTER TABLE interfaces ADD validation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interfaces ADD CONSTRAINT FK_E358958EA2274850 FOREIGN KEY (validation_id) REFERENCES validation (id)');
        $this->addSql('CREATE INDEX IDX_E358958EA2274850 ON interfaces (validation_id)');
        $this->addSql('ALTER TABLE project ADD permission_id INT DEFAULT NULL, ADD interfaces_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEFED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEE46C54C0 FOREIGN KEY (interfaces_id) REFERENCES interfaces (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEFED90CCA ON project (permission_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEE46C54C0 ON project (interfaces_id)');
        $this->addSql('ALTER TABLE role ADD files_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AA3E65B2F FOREIGN KEY (files_id) REFERENCES file (id)');
        $this->addSql('CREATE INDEX IDX_57698A6AA3E65B2F ON role (files_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_role');
        $this->addSql('DROP TABLE role_uapp');
        $this->addSql('DROP TABLE uapp_bundle');
        $this->addSql('DROP TABLE user_project');
        $this->addSql('ALTER TABLE bundle DROP FOREIGN KEY FK_A57B32FDE46C54C0');
        $this->addSql('DROP INDEX IDX_A57B32FDE46C54C0 ON bundle');
        $this->addSql('ALTER TABLE bundle DROP interfaces_id');
        $this->addSql('ALTER TABLE interfaces DROP FOREIGN KEY FK_E358958EA2274850');
        $this->addSql('DROP INDEX IDX_E358958EA2274850 ON interfaces');
        $this->addSql('ALTER TABLE interfaces DROP validation_id');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEFED90CCA');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEE46C54C0');
        $this->addSql('DROP INDEX IDX_2FB3D0EEFED90CCA ON project');
        $this->addSql('DROP INDEX IDX_2FB3D0EEE46C54C0 ON project');
        $this->addSql('ALTER TABLE project DROP permission_id, DROP interfaces_id');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AA3E65B2F');
        $this->addSql('DROP INDEX IDX_57698A6AA3E65B2F ON role');
        $this->addSql('ALTER TABLE role DROP files_id');
    }
}
