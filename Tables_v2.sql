-- The database name has been made comp344, temprarily
USE comp344; 
CREATE TABLE IF NOT EXISTS `AccessGroup` (
	`AG_id` INT NOT NULL,
    `AG_name` VARCHAR(45),
    `AG_desc` VARCHAR(255),
    PRIMARY KEY (`AG_id`)
);

CREATE TABLE IF NOT EXISTS `Commands` (
	`Cmd_id` INT NOT NULL,
    `Cmd_name` VARCHAR(45),
    `Cmd_URL` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`Cmd_id`)
);

CREATE TABLE IF NOT EXISTS `AccessGroupCommands` (
	`AGC_id` INT NOT NULL,
    `AGC_AG_id` INT NOT NULL,
    `AGC_Cmd_id` INT NOT NULL,
    `AGC_desc` VARCHAR(255),
    PRIMARY KEY (`AGC_id`),
    CONSTRAINT `fk_AGC_AG_id`
		FOREIGN KEY(`AGC_AG_id`)
        REFERENCES `AccessGroup` (`AG_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
	CONSTRAINT `fk_AGC_Cmd_id`
		FOREIGN KEY(`AGC_Cmd_id`)
        REFERENCES `Commands` (`Cmd_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Rating` (
	`id` INT NOT NULL,
    `Rating_Shopper_id` INT,
    `Rating_Product_id` INT,
    `Rating_Value` INT,
    `Rating_Review` MEDIUMBLOB,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `ShopperGroup` (
	`ShopGrp_id` INT NOT NULL,
    `ShopGrp_Name` VARCHAR(45) NOT NULL,
    `ShopGrp_Description` VARCHAR(256),
    PRIMARY KEY (`ShopGrp_id`)
);

CREATE TABLE IF NOT EXISTS `Shopper` (
	`shopper_id` INT NOT NULL,
    `sh_username` VARCHAR(30) NOT NULL,
    `sh_password` CHAR(60) NOT NULL,
    `sh_email` VARCHAR(64) NOT NULL,
    `sh_phone` VARCHAR(45),
    `sh_type` CHAR(1) NOT NULL,
    `sh_shopgrp` INT,
    `sh_field1` VARCHAR(128),
    `sh_field2` VARCHAR(128),
    PRIMARY KEY (`shopper_id`),
    CONSTRAINT `fk_sh_shopgrp`
		FOREIGN KEY(`sh_shopgrp`)
        REFERENCES `ShopperGroup` (`ShopGrp_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `AccessUserGroup` (
	`AUG_id` INT NOT NULL,
    `AUG_Shopper_id` INT NOT NULL,
    `AUG_AG_id` INT NOT NULL,
    PRIMARY KEY (`AUG_id`),
    CONSTRAINT `fk_AUG_Shopper_id`
		FOREIGN KEY(`AUG_Shopper_id`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
	CONSTRAINT `fk_AUG_AG_id`
		FOREIGN KEY(`AUG_AG_id`)
        REFERENCES `AccessGroup` (`AG_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Shaddr` (
	`shaddr_id` INT(11) NOT NULL,
    `shopper_id` INT(11) NOT NULL,
    `sh_title` CHAR(8),
    `sh_firstname` VARCHAR(20),
    `sh_familyname` VARCHAR(20),
    `sh_street1` VARCHAR(64),
    `sh_street2` VARCHAR(64),
    `sh_city` VARCHAR(32),
    `sh_state` VARCHAR(8),
    `sh_postcode` VARCHAR(10),
    `sh_country` VARCHAR(32),
    PRIMARY KEY (`shaddr_id`),
    CONSTRAINT `fk_shopper_id`
		FOREIGN KEY(`shopper_id`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Order` (
	`Order_id` INT NOT NULL,
    `Order_Shopper` INT NOT NULL,
    `Order_Shaddr` INT NOT NULL,
    `Order_TimeStamp` TIMESTAMP,
    `Order_PayMethod` CHAR,
    `Order_Payment_PAN` VARCHAR(20),
    `Order_PaymentAuthorized` BOOLEAN,
    `Order_Picked` BOOLEAN,
    `Order_Shipped` BOOLEAN,
    `Order_ShipDate` DATE,
    `Order_Paid` BOOLEAN,
    `Order_PayDate` DATE,
    `Order_ShippingAmount` DECIMAL(10,2),
    `Order_TaxAmount` DECIMAL(10,2),
    `Order_ProductAmount` DECIMAL(10,2),
    `Order_Total` DECIMAL(10,2),
    PRIMARY KEY (`Order_id`),
    CONSTRAINT `fk_Order_Shopper`
		FOREIGN KEY(`Order_Shopper`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
	CONSTRAINT `fk_Order_Shaddr`
		FOREIGN KEY(`Order_Shaddr`)
        REFERENCES `Shaddr` (`shaddr_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Category` (
	`cat_id` INT NOT NULL,
    `cat_name` VARCHAR(40) NOT NULL,
    `cat_desc` VARCHAR(128),
    `cat_img_url` VARCHAR(128),
    `cat_disp_cmd` VARCHAR(128),
    PRIMARY KEY (`cat_id`)
);

CREATE TABLE IF NOT EXISTS `Session` (
	`id` CHAR(32) NOT NULL,
    `Shopper_id` INT,
    `data` MEDIUMBLOB,
    `time` TIMESTAMP NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_Shopper_id2`
		FOREIGN KEY(`Shopper_id`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Product` (
	`prod_id` INT NOT NULL,
    `prod_name` VARCHAR(40) NOT NULL,
    `prod_desc` VARCHAR(128),
    `prod_img_url` VARCHAR(128),
    `prod_long_desc` VARCHAR(256),
    `prod_sku` CHAR(16),
    `prod_disp_cmd` VARCHAR(128),
    `prod_weight` DECIMAL(6,2),
    `prod_l` INT,
    `prod_w` INT,
    `prod_h` INT,
    PRIMARY KEY (`prod_id`)
);

CREATE TABLE IF NOT EXISTS `Log` (
	`id` INT NOT NULL,
    `Log_Shopper_id` INT,
    `Log_Cmd_id` INT,
    `Log_Cat_id` INT,
    `Log_Prod_id` INT,
    `Log_TimeStamp` TIMESTAMP,
    PRIMARY KEY (`id`),
	CONSTRAINT `fk_Log_Shopper_id`
		FOREIGN KEY(`Log_Shopper_id`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
	CONSTRAINT `fk_Log_Cmd_id`
		FOREIGN KEY(`Log_Cmd_id`)
        REFERENCES `Commands` (`Cmd_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
	CONSTRAINT `fk_Log_Cat_id`
		FOREIGN KEY(`Log_Cat_id`)
        REFERENCES `Category` (`cat_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
	CONSTRAINT `fk_Log_Prod_id`
		FOREIGN KEY(`Log_Prod_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `ProdPrices` (
	`PrPr_id` INT NOT NULL,
    `PrPr_Prod_id` INT,
    `PrPr_ShopGrp` INT,
    `PrPr_Price` DECIMAL(10,2),
    PRIMARY KEY (`PrPr_id`),
    CONSTRAINT `fk_PrPr_Prod_id`
		FOREIGN KEY(`PrPr_Prod_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Attribute` (
	`id` INT NOT NULL,
    `name` VARCHAR(45),
    `Product_prod_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_Product_prod_id`
		FOREIGN KEY(`Product_Prod_id`)
		REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `AttributeValue` (
	`AttrVal_id` INT NOT NULL,
    `AttrVal_Value` VARCHAR(45) NOT NULL,
    `AttrVal_Attr_id` INT NOT NULL,
    `AttrVal_Prod_id` INT NOT NULL,
    `AttrVal_Price` DECIMAL(10,2),
    PRIMARY KEY (`AttrVal_id`),
    CONSTRAINT `fk_AttrVal_Attr_id`
		FOREIGN KEY(`AttrVal_Attr_id`)
        REFERENCES `Attribute` (`id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_AttrVal_Prod_id`
		FOREIGN KEY(`AttrVal_Prod_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `OrderProduct` (
	`OP_id` INT NOT NULL,
    `OP_Order_id` INT NOT NULL,
    `OP_prod_id` INT NOT NULL,
    `OP_qty` INT,
    PRIMARY KEY (`OP_id`),
    CONSTRAINT `fk_OP_Order_id`
		FOREIGN KEY(`OP_Order_id`)
        REFERENCES `Order` (`Order_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_OP_prod_id`
		FOREIGN KEY(`OP_prod_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `OrderProductAttributeValues` (
	`OPAttr_id` INT NOT NULL,
    `OPAttr_op_id` INT NOT NULL,
    `OPAttr_Attr_id` INT NOT NULL,
    `OPAttr_AttrVal_id` INT NOT NULL,
    PRIMARY KEY (`OPAttr_id`, `OPAttr_op_id`),
    CONSTRAINT `fk_OPAttr_op_id`
		FOREIGN KEY(`OPAttr_op_id`)
		REFERENCES `OrderProduct` (`OP_id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
    CONSTRAINT `fk_OPAttr_AttrVal_id`
		FOREIGN KEY(`OPAttr_AttrVal_id`)
		REFERENCES `AttributeValue` (`AttrVal_id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Specials` (
	`id` INT NOT NULL,
    `Special_Product_id` INT NOT NULL,
    `Special_ProdAttrVal` INT,
    `Special_ProdPrices_id` INT,
    `Special_Start_Date` DATE NOT NULL,
    `Special_End_Date` DATE NOT NULL,
    `Special_Comment` VARCHAR(255),
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_Special_Product_id`
		FOREIGN KEY(`Special_Product_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_Special_ProdAttrVal`
		FOREIGN KEY(`Special_ProdAttrVal`)
        REFERENCES `AttributeValue` (`AttrVal_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `Stock` (
	`id` INT NOT NULL,
    `Stock_Prod_id` INT,
    `Stock_Prod_AttrValue_id` INT,
    `Stock_Qty` INT,
    `Stock_SKU` VARCHAR(60),
    `Stock_Location` VARCHAR(60),
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_Stock_Prod_id`
		FOREIGN KEY(`Stock_Prod_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_Stock_Prod_AttrValue_id`
		FOREIGN KEY(`Stock_Prod_AttrValue_id`)
        REFERENCES `AttributeValue` (`AttrVal_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `CgPrRel` (
	`Id` INT NOT NULL,
    `CgPr_cat_id` INT NOT NULL,
    `CgPr_prod_id` INT NOT NULL,
    PRIMARY KEY (`Id`),
    CONSTRAINT `fk_CgPr_cat_id`
		FOREIGN KEY(`CgPr_cat_id`)
        REFERENCES `Category` (`cat_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_CgPr_prod_id`
		FOREIGN KEY(`CgPr_prod_id`)
        REFERENCES `Product` (`prod_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `CgryRel` (
	`Id` INT NOT NULL,
    `cgryrel_id_parent` INT NOT NULL,
    `cgryrel_id_child` INT NOT NULL,
    `cgryrel_sequence` INT,
    PRIMARY KEY (`Id`),
    CONSTRAINT `fk_cgryrel_id_parent`
		FOREIGN KEY(`cgryrel_id_parent`)
        REFERENCES `Category` (`cat_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_cgryrel_id_child`
		FOREIGN KEY(`cgryrel_id_child`)
        REFERENCES `Category` (`cat_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);