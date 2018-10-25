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
  `shopper_id` int(11) NOT NULL AUTO_INCREMENT,
  `sh_username` varchar(30) NOT NULL,
  `sh_password` char(60) NOT NULL,
  `sh_email` varchar(64) NOT NULL,
  `sh_phone` varchar(45) DEFAULT NULL,
  `sh_type` char(1) NOT NULL,
  `sh_shopgrp` int(11) DEFAULT NULL,
  `sh_field1` varchar(128) DEFAULT NULL,
  `sh_field2` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`shopper_id`),
  UNIQUE KEY `sh_email` (`sh_email`),
  UNIQUE KEY `sh_username` (`sh_username`),
  KEY `fk_sh_shopgrp` (`sh_shopgrp`),
  CONSTRAINT `fk_sh_shopgrp`
		FOREIGN KEY (`sh_shopgrp`)
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
  `Order_id` int(11) NOT NULL AUTO_INCREMENT,
  `Order_Shopper` int(11) NOT NULL,
  `Order_Shaddr` int(11) NOT NULL,
  `Order_TimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Order_PayMethod` char(1) DEFAULT NULL,
  `Order_Payment_PAN` varchar(20) DEFAULT NULL,
  `Order_PaymentAuthorized` tinyint(1) DEFAULT NULL,
  `Order_Picked` tinyint(1) DEFAULT NULL,
  `Order_PP_id` int(11) DEFAULT NULL,
  `Order_PickedDateTime` datetime DEFAULT NULL,
  `Order_Shipped` tinyint(1) DEFAULT NULL,
  `Order_ShippedDateTime` datetime DEFAULT NULL,
  `Order_ShipDate` date DEFAULT NULL,
  `Order_Delivered` datetime DEFAULT NULL,
  `Order_Paid` tinyint(1) DEFAULT NULL,
  `Order_PayDate` date DEFAULT NULL,
  `Order_ShippingAmount` decimal(10,2) DEFAULT NULL,
  `Order_TaxAmount` decimal(10,2) DEFAULT NULL,
  `Order_ProductAmount` decimal(10,2) DEFAULT NULL,
  `Order_Total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Order_id`),
  KEY `fk_Order_Shopper` (`Order_Shopper`),
  KEY `fk_Order_Shaddr` (`Order_Shaddr`),
  CONSTRAINT `fk_Order_Shaddr`
		FOREIGN KEY (`Order_Shaddr`)
		REFERENCES `Shaddr` (`shaddr_id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_Shopper`
		FOREIGN KEY (`Order_Shopper`)
		REFERENCES `Shopper` (`shopper_id`)
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
  `prod_id` INT NOT NULL AUTO_INCREMENT,
  `prod_name` VARCHAR(40) NOT NULL,
  `prod_desc` VARCHAR(128) NULL DEFAULT NULL,
  `prod_img_url` VARCHAR(128) NULL DEFAULT NULL,
  `prod_long_desc` VARCHAR(256) NULL DEFAULT NULL,
  `prod_sku` CHAR(16) NULL DEFAULT NULL,
  `prod_disp_cmd` VARCHAR(128) NULL DEFAULT NULL,
  `prod_weight` DECIMAL(6,2) NULL,
  `prod_l` INT NULL,
  `prod_w` INT NULL,
  `prod_h` INT NULL,
  PRIMARY KEY (`prod_id`),
  INDEX `prod_name` (`prod_name` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = latin1
COMMENT = 'Key product information.';

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
        ON UPDATE NO ACTION,
	 CONSTRAINT `fk_PrPr_ShopGrp`
		FOREIGN KEY(`PrPr_ShopGrp`)
        REFERENCES `ShopperGroup` (`ShopGrp_id`)
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

CREATE TABLE IF NOT EXISTS `SupQuery` (
    `SQ_id` INT NOT NULL,
    `SQ_shopper_id` INT NOT NULL,
    `SQ_message` TEXT NOT NULL,
    `SQ_resolved` BOOLEAN NOT NULL,
    `SQ_date_posted` TIMESTAMP NOT NULL,
    PRIMARY KEY (`SQ_id`),
    CONSTRAINT `fk_SQ_shopper_id`
        FOREIGN KEY(`SQ_shopper_id`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `CSReply` (
    `CS_id` INT NOT NULL,
    `CS_shopper_id` INT NOT NULL,
    `CS_SQ_id` INT NOT NULL,
    `CS_message` TEXT NOT NULL,
    `CS_date_posted` TIMESTAMP NOT NULL,
    PRIMARY KEY (`CS_id`),
    CONSTRAINT `fk_CS_SQ_id`
        FOREIGN KEY(`CS_SQ_id`)
        REFERENCES `SupQuery` (`SQ_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_CS_shopper_id`
        FOREIGN KEY(`CS_shopper_id`)
        REFERENCES `Shopper` (`shopper_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `pass_session` (
	`user_id` INT NOT NULL,
	`token` VARCHAR(45),
	`timestamp` DATE,
	PRIMARY KEY (`user_id`),
	CONSTRAINT `session_order`
		FOREIGN KEY(`user_id`)
		REFERENCES `Order` (`Order_id`)
);

CREATE TABLE IF NOT EXISTS `Cart` (
	`Cart_id` INT NOT NULL AUTO_INCREMENT,
    `Session_session_id` CHAR(32) NOT NULL,
    PRIMARY KEY (`Cart_id`),
    CONSTRAINT `cartSession`
		FOREIGN KEY (`Session_session_id`)
		REFERENCES `Session` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `CartProduct` (
  `CartProduct_id` INT NOT NULL AUTO_INCREMENT,
  `Cart_id` INT NOT NULL,
  `Product_prod_id` INT NOT NULL,
  `CP_qty` INT NULL,
  INDEX `fk_table1_Cart1_idx` (`Cart_id` ASC),
  INDEX `fk_table1_Product1_idx` (`Product_prod_id` ASC),
  PRIMARY KEY (`CartProduct_id`),
  CONSTRAINT `fk_table1_Cart1`
    FOREIGN KEY (`Cart_id`)
    REFERENCES `Cart` (`Cart_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_Product1`
    FOREIGN KEY (`Product_prod_id`)
    REFERENCES `Product` (`prod_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `CartProductAttribute` (
  `CartProductAttribute_id` INT NOT NULL AUTO_INCREMENT,
  `Attribute_id` INT NOT NULL,
  `Attribute_value_id` INT NOT NULL,
  `CartProduct_CP_id` INT NOT NULL,
  PRIMARY KEY (`CartProductAttribute_id`),
  INDEX `fk_CartProductAttribute_Attribute1_idx` (`Attribute_id` ASC),
  INDEX `fk_CartProductAttribute_CartProduct1_idx` (`CartProduct_CP_id` ASC),
  CONSTRAINT `fk_CartProductAttribute_Attribute1`
    FOREIGN KEY (`Attribute_id`)
    REFERENCES `Attribute` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AttributeValue`
    FOREIGN KEY (`Attribute_value_id`)
    REFERENCES `AttributeValue` (`AttrVal_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CartProductAttribute_CartProduct1`
    FOREIGN KEY (`CartProduct_CP_id`)
    REFERENCES `CartProduct` (`CartProduct_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);