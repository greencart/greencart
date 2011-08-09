INSERT INTO `gc_administrators` (`username`, `password`, `name`, `email`, `created`, `updated`) VALUES
('admin', 'abeab275781521cd276e77e7965fa19ae99cdcd4', 'Sebastian Ionescu', 'sebastian.c.ionescu@gmail.com', NOW(), NOW());

INSERT INTO `gc_configuration` (`key`, `value`, `updated`) VALUES
('MAILER_SMTP_HOST'              , '', 0),
('MAILER_SMTP_PORT'              , '25', 0),
('MAILER_SMTP_AUTH'              , '', 0),
('MAILER_SMTP_USERNAME'          , '', 0),
('MAILER_SMTP_PASSWORD'          , '', 0),
('MAILER_SMTP_ENCRYPTION'        , '', 0),
('MAILER_SMTP_TIMEOUT'           , '15', 0),

('SEO_KEYWORDS'                  , 'greencart,ecommerce,platform', 0),
('SEO_KEYWORDS_MAX'              , '9', 0),

('SHOP_AUTHOR'                   , 'Sebastian Ionescu (sebastian.c.ionescu [at] gmail.com)', 0),
('SHOP_COPYRIGHT'                , '(c) 2011 GreenCart', 0),
('SHOP_DESCRIPTION'              , 'Open Source eCommerce Platform', 0),
('SHOP_EMAIL_CONTACT'            , 'contact@localhost', 0),
('SHOP_EMAIL_NOREPLY'            , 'noreply@localhost', 0),
('SHOP_EMAIL_WEBMASTER'          , 'webmaster@localhost', 0),
('SHOP_NAME'                     , 'GreenCart', 0),
('SHOP_OWNER'                    , 'GreenCart', 0),
('SHOP_TITLE'                    , 'GreenCart', 0),
('SHOP_TITLE_SEPARATOR'          , ' | ', 0);

UPDATE `gc_configuration` SET `updated` = NOW();
