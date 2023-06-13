<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609143259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, shopproduct_id INT NOT NULL, my_order_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_52EA1F0911AF49CC (shopproduct_id), INDEX IDX_52EA1F09BFCDF877 (my_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product (id INT AUTO_INCREMENT NOT NULL, sub_category_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, subtitle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, slug VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, illustration2 VARCHAR(255) NOT NULL, illustration3 VARCHAR(255) NOT NULL, illustration4 VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_D0794487F7BFE87C (sub_category_id), INDEX IDX_D079448744F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_shop_product_color (shop_product_id INT NOT NULL, shop_product_color_id INT NOT NULL, INDEX IDX_897C78373FF78B7C (shop_product_id), INDEX IDX_897C783790377293 (shop_product_color_id), PRIMARY KEY(shop_product_id, shop_product_color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_shop_product_size (shop_product_id INT NOT NULL, shop_product_size_id INT NOT NULL, INDEX IDX_8E0D0293FF78B7C (shop_product_id), INDEX IDX_8E0D02971A7B7A3 (shop_product_size_id), PRIMARY KEY(shop_product_id, shop_product_size_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_category_shop_product_sub_category (shop_product_category_id INT NOT NULL, shop_product_sub_category_id INT NOT NULL, INDEX IDX_204F74FB206E2C75 (shop_product_category_id), INDEX IDX_204F74FB863E5A6C (shop_product_sub_category_id), PRIMARY KEY(shop_product_category_id, shop_product_sub_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_product_sub_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0911AF49CC FOREIGN KEY (shopproduct_id) REFERENCES shop_product (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09BFCDF877 FOREIGN KEY (my_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE shop_product ADD CONSTRAINT FK_D0794487F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES shop_product_sub_category (id)');
        $this->addSql('ALTER TABLE shop_product ADD CONSTRAINT FK_D079448744F5D008 FOREIGN KEY (brand_id) REFERENCES shop_product_brand (id)');
        $this->addSql('ALTER TABLE shop_product_shop_product_color ADD CONSTRAINT FK_897C78373FF78B7C FOREIGN KEY (shop_product_id) REFERENCES shop_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product_shop_product_color ADD CONSTRAINT FK_897C783790377293 FOREIGN KEY (shop_product_color_id) REFERENCES shop_product_color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product_shop_product_size ADD CONSTRAINT FK_8E0D0293FF78B7C FOREIGN KEY (shop_product_id) REFERENCES shop_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product_shop_product_size ADD CONSTRAINT FK_8E0D02971A7B7A3 FOREIGN KEY (shop_product_size_id) REFERENCES shop_product_size (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product_category_shop_product_sub_category ADD CONSTRAINT FK_204F74FB206E2C75 FOREIGN KEY (shop_product_category_id) REFERENCES shop_product_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_product_category_shop_product_sub_category ADD CONSTRAINT FK_204F74FB863E5A6C FOREIGN KEY (shop_product_sub_category_id) REFERENCES shop_product_sub_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F0911AF49CC');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09BFCDF877');
        $this->addSql('ALTER TABLE shop_product DROP FOREIGN KEY FK_D0794487F7BFE87C');
        $this->addSql('ALTER TABLE shop_product DROP FOREIGN KEY FK_D079448744F5D008');
        $this->addSql('ALTER TABLE shop_product_shop_product_color DROP FOREIGN KEY FK_897C78373FF78B7C');
        $this->addSql('ALTER TABLE shop_product_shop_product_color DROP FOREIGN KEY FK_897C783790377293');
        $this->addSql('ALTER TABLE shop_product_shop_product_size DROP FOREIGN KEY FK_8E0D0293FF78B7C');
        $this->addSql('ALTER TABLE shop_product_shop_product_size DROP FOREIGN KEY FK_8E0D02971A7B7A3');
        $this->addSql('ALTER TABLE shop_product_category_shop_product_sub_category DROP FOREIGN KEY FK_204F74FB206E2C75');
        $this->addSql('ALTER TABLE shop_product_category_shop_product_sub_category DROP FOREIGN KEY FK_204F74FB863E5A6C');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE shop_product');
        $this->addSql('DROP TABLE shop_product_shop_product_color');
        $this->addSql('DROP TABLE shop_product_shop_product_size');
        $this->addSql('DROP TABLE shop_product_brand');
        $this->addSql('DROP TABLE shop_product_category');
        $this->addSql('DROP TABLE shop_product_category_shop_product_sub_category');
        $this->addSql('DROP TABLE shop_product_color');
        $this->addSql('DROP TABLE shop_product_size');
        $this->addSql('DROP TABLE shop_product_sub_category');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
