INSERT INTO `gc_administrators` (`username`, `password`, `name`, `email`, `created`, `updated`) VALUES
('admin', 'abeab275781521cd276e77e7965fa19ae99cdcd4', 'Sebastian Ionescu', 'sebastian.c.ionescu@gmail.com', NOW(), NOW());

INSERT INTO `gc_configuration` (`key`, `value`, `updated`) VALUES
('SEO_KEYWORDS'                  , 'greencart,ecommerce,platform', 0),
('SEO_KEYWORDS_MAX'              , '9', 0),
('SHOP_NAME'                     , 'GreenCart', 0),
('SHOP_TITLE'                    , 'GreenCart', 0),
('SHOP_TITLE_SEPARATOR'          , ' | ', 0),
('SHOP_DESCRIPTION'              , 'Open Source eCommerce Platform', 0),
('SHOP_OWNER'                    , 'GreenCart', 0);

UPDATE `gc_configuration` SET `updated` = NOW();
