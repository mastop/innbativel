-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.11 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para innbativel
CREATE DATABASE IF NOT EXISTS `innbativel` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `innbativel`;


-- Copiando estrutura para tabela innbativel.banners
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.banners: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.categories: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `title`, `slug`, `display_order`) VALUES
	(1, 'Hotéis', 'hoteis', 1),
	(2, 'Pacotes Nacionais', 'pacotes-nacionais', 2),
	(3, 'Pacotes Internacionais', 'pacotes-internacionais', 3),
	(4, 'Passeios e Gastronomia', 'passeios-e-gastronomia', 4),
	(5, 'Pré-Reservas', 'passeiospre-reservas', 5);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `comments_offer_id_index` (`offer_id`),
  KEY `comments_user_id_index` (`user_id`),
  CONSTRAINT `comments_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.comments: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.configurations
CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `configurations_name_index` (`name`),
  KEY `configurations_value_index` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.configurations: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `configurations` DISABLE KEYS */;
/*!40000 ALTER TABLE `configurations` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.discount_coupons
CREATE TABLE IF NOT EXISTS `discount_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `offer_id` int(10) unsigned DEFAULT NULL,
  `display_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `qty_used` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_coupons_user_id_index` (`user_id`),
  KEY `discount_coupons_offer_id_index` (`offer_id`),
  CONSTRAINT `discount_coupons_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `discount_coupons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.discount_coupons: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `discount_coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount_coupons` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.facebook
CREATE TABLE IF NOT EXISTS `facebook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.facebook: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `facebook` DISABLE KEYS */;
/*!40000 ALTER TABLE `facebook` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.faqs
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.faqs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.geo_categories
CREATE TABLE IF NOT EXISTS `geo_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.geo_categories: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `geo_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `geo_categories` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.migrations: ~30 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`migration`, `batch`) VALUES
	('0000_00_00_000001_setup_permissions_table', 1),
	('0000_00_00_000002_setup_roles_table', 1),
	('0000_00_00_000003_setup_users_table', 1),
	('0000_00_00_000004_setup_role_user_table', 1),
	('0000_00_00_000005_setup_permission_role_table', 1),
	('0000_00_00_000006_setup_profiles_table', 1),
	('0000_00_00_000007_setup_facebook_table', 1),
	('0000_00_00_000007_setup_users_indications_table', 1),
	('0000_00_00_000008_setup_users_credits_table', 1),
	('0000_00_00_000009_setup_ngos_table', 1),
	('0000_00_00_000010_setup_offers_table', 1),
	('0000_00_00_000011_setup_offers_options_table', 1),
	('0000_00_00_000012_setup_banners_table', 1),
	('0000_00_00_000013_setup_offers_images_table', 1),
	('0000_00_00_000014_setup_categories_table', 1),
	('0000_00_00_000015_setup_geo_categories_table', 1),
	('0000_00_00_000016_setup_saveme_table', 1),
	('0000_00_00_000017_setup_comments_table', 1),
	('0000_00_00_000018_setup_discount_coupons_table', 1),
	('0000_00_00_000019_setup_orders_table', 1),
	('0000_00_00_000020_setup_orders_offers_options_table', 1),
	('0000_00_00_000021_setup_vouchers_table', 1),
	('0000_00_00_000022_setup_configurations_table', 1),
	('0000_00_00_000023_setup_faqs_table', 1),
	('0000_00_00_000024_setup_pre_bookings_table', 1),
	('0000_00_00_000025_setup_tell_us_table', 1),
	('0000_00_00_000026_setup_partners_testimonies_table', 1),
	('0000_00_00_000027_setup_suggest_a_trip_table', 1),
	('0000_00_02_000001_setup_states_table', 1),
	('2013_11_18_002225_create_password_reminders_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.ngos
CREATE TABLE IF NOT EXISTS `ngos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.ngos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `ngos` DISABLE KEYS */;
INSERT INTO `ngos` (`id`, `name`) VALUES
	(1, 'ONG DOS PROGRAMADORES FOREVER ALONE'),
	(2, 'ONG DAS PRIMAS');
/*!40000 ALTER TABLE `ngos` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offers
CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(10) unsigned NOT NULL,
  `ngo_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `destiny` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `event` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saveme_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `general_rules` text COLLATE utf8_unicode_ci,
  `features` text COLLATE utf8_unicode_ci,
  `installment` int(11) DEFAULT NULL,
  `starts_on` datetime DEFAULT NULL,
  `ends_on` datetime DEFAULT NULL,
  `cover_img` text COLLATE utf8_unicode_ci,
  `offer_old_img` text COLLATE utf8_unicode_ci,
  `newsletter_img` text COLLATE utf8_unicode_ci,
  `saveme_img` text COLLATE utf8_unicode_ci,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT '99',
  `pre_booking_order` int(11) NOT NULL DEFAULT '99',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `offers_partner_id_index` (`partner_id`),
  KEY `offers_ngo_id_index` (`ngo_id`),
  CONSTRAINT `offers_ngo_id_foreign` FOREIGN KEY (`ngo_id`) REFERENCES `ngos` (`id`),
  CONSTRAINT `offers_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=793 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offers: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `offers` DISABLE KEYS */;
INSERT INTO `offers` (`id`, `partner_id`, `ngo_id`, `title`, `subtitle`, `destiny`, `description`, `event`, `saveme_title`, `slug`, `allow_coupons`, `general_rules`, `features`, `installment`, `starts_on`, `ends_on`, `cover_img`, `offer_old_img`, `newsletter_img`, `saveme_img`, `video`, `display_order`, `pre_booking_order`, `created_at`, `updated_at`) VALUES
	(783, 1, 1, 'Gramado - RS', 'Aéreo de 14 capitais | Parque de Neve | Até 7 diárias', 'Gramado - RS', 'Traga toda a família para muita aventura no Snowland Parque de Neve em Gramado! Muita adrenalina e diversão esperam por você!', '', 'Aéreo de 14 capitais | Parque de Neve | Até 7 diárias', 'gramado-rs', 1, '<p><span style="text-decoration: underline;">Pacote de Viagem</span></p><ul><li>Pacote v&aacute;lido no per&iacute;odo de 15/01/14 a 30/10/14 (exceto julho, feriados e eventos na regi&atilde;o), mediante disponibilidade.</li><li>Ao clicar em &ldquo;Comprar&rdquo; escolha a cidade de embarque e a quantidade de noites da sua viagem.</li></ul><p><strong><span style="text-decoration: underline;">Sa&iacute;das de S&atilde;o Paulo, Curitiba e Florian&oacute;polis</span></strong></p><p><strong>Op&ccedil;&atilde;o 1:</strong>&nbsp;3 noites de R$1098 por R$449. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>Op&ccedil;&atilde;o 2:</strong>&nbsp;5 noites de R$1298 por R$549. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>Op&ccedil;&atilde;o 3:</strong>&nbsp;7 noites de R$1498 por R$649. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><strong>&nbsp;</strong></p><p><strong><span style="text-decoration: underline;">Sa&iacute;das de Vit&oacute;ria, Salvador, Rio de Janeiro, Bras&iacute;lia, Belo Horizonte, Campinas e Campo Grande</span></strong></p><p><strong>Op&ccedil;&atilde;o 1:&nbsp;</strong>3 noites de R$1498 por R$649. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p><strong>Op&ccedil;&atilde;o 2:&nbsp;</strong>5 noites de R$1698 por R$749. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>Op&ccedil;&atilde;o 3:&nbsp;</strong>7 noites de R$1898 por R$849. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>&nbsp;</strong></p><p><strong><span style="text-decoration: underline;">Sa&iacute;das de Aracaju, Fortaleza, Recife e Jo&atilde;o Pessoa</span></strong></p><p><strong>Op&ccedil;&atilde;o 1:&nbsp;</strong>3 noites de R$1798&nbsp;por R$799. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>Op&ccedil;&atilde;o 2:&nbsp;</strong>5 noites de R$1998&nbsp;por R$899. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p><strong>Op&ccedil;&atilde;o 3:&nbsp;</strong>7 noites de R$2198&nbsp;por R$999. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p><p>&nbsp;</p><ul><li><strong>Confirma&ccedil;&atilde;o da reserva mediante disponibilidade na base tarif&aacute;ria promocional do voo e da pousada.</strong></li><li>O pacote inclui:&nbsp;Passagens a&eacute;reas para Porto Alegre + transfer regular aeroporto Porto Alegre/hotel Serra Ga&uacute;cha/aeroporto Porto Alegre + Hospedagem na Pousada Casa de Veneza, ou similar + Caf&eacute; da manh&atilde; + Transfer para o parque de neve Snowland.</li><li>Cia. A&eacute;rea&nbsp;Tam, Gol, Avianca ou Azul, na classe econ&ocirc;mica promocional, podendo ser alterada conforme disponibilidade.</li><li>V&aacute;lido exclusivamente para 1 pessoa, com acomoda&ccedil;&atilde;o em&nbsp;Quarto Duplo. Caso viaje sozinho, &eacute; obrigat&oacute;ria&nbsp;a troca por Quarto Single, mediante o pagamento de taxa extra de&nbsp;R$60 por noite, diretamente &agrave; operadora, no momento da reserva.</li><li>N&atilde;o inclui taxas de embarque e emiss&atilde;o (R$150&nbsp;por pessoa), que dever&atilde;o ser pagas diretamente &agrave; operadora, no momento da reserva.</li><li>Obrigat&oacute;rio Seguro Viagem, que dever&aacute; ser adquirido diretamente com a operadora. Cliente INNBat&iacute;vel tem desconto especial: R$35 para todo o per&iacute;odo.</li><li>N&atilde;o inclui despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, ingressos para o paque e outros consumos n&atilde;o citados na oferta.</li><li>Para 1 crian&ccedil;a com at&eacute;&nbsp;2 anos&nbsp;incompletos, acompanhada de 2 adultos pagantes, ser&aacute; cobrada apenas taxa de&nbsp;R$185. Para crian&ccedil;a com idade a partir de 2&nbsp;anos, ser&aacute; necess&aacute;ria a aquisi&ccedil;&atilde;o de um novo cupom.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute;&nbsp;n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Preencha e envie o formul&aacute;rio de reserva imediatamente ap&oacute;s a compra, atrav&eacute;s do site&nbsp;<a href="http://www.tourinn.com.br/?url=compra_coletiva" target="_blank"><strong>http://www.tourinn.com.br/?url=compra_coletiva</strong></a>.</li><li>Formul&aacute;rios enviados com atraso sofrer&atilde;o altera&ccedil;&otilde;es nos valores e nas condi&ccedil;&otilde;es de reserva.</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva. Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas.</li><li>Os vouchers (documentos) dos servi&ccedil;os contratados ser&atilde;o disponibilizados pela operadora respons&aacute;vel com at&eacute; 48 horas de anteced&ecirc;ncia &agrave; data de embarque. Eles ser&atilde;o enviados por e-mail.</li><li>N&atilde;o h&aacute; direito de remarca&ccedil;&atilde;o em caso de n&atilde;o comparecimento ou perda do v&ocirc;o.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es entre em contato atrav&eacute;s do e-mail:&nbsp;</strong><a href="mailto:reservas@tourinn.com.br"><strong>reservas@tourinn.com.br</strong></a><strong>&nbsp;ou ligue (11) 3614-9010, (48) 3206-0902, (48) 3206-0894 e (48) 3369-9083, de segunda a sexta, das 9h &agrave;s 17h.</strong></li><li>As taxas e seguro viagem poder&atilde;o ser parcelados em at&eacute; 12x no cart&atilde;o de cr&eacute;dito diretamente com a operadora.</li></ul><p><span style="text-decoration: underline;">Momento do Embarque</span></p><ul><li>Para embarque &eacute; necess&aacute;rio apresentar a carteira de identidade nacional (RG) emitida pela Secretaria de Seguran&ccedil;a P&uacute;blica, original, em bom estado, na cor verde, com no m&aacute;ximo 10 anos de emiss&atilde;o, Carteira Nacional de Habilita&ccedil;&atilde;o (CNH), Carteira Profissional emitida pelos Conselhos, Carteira Profissional original ou Certificado de Reservista. A documenta&ccedil;&atilde;o &eacute; de exclusiva responsabilidade do passageiro.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 07 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email&nbsp;<a href="mailto:faleconosco@innbativel.com.br"><strong>faleconosco@innbativel.com.br</strong></a>.</li><li>Ap&oacute;s os 07 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva; em caso de cancelamento, n&atilde;o haver&aacute; a devolu&ccedil;&atilde;o do valor pago.</li><li>Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas e o cancelamento resultar&aacute; na perda total do cupom</li></ul>', '<ul><li>Economize at&eacute; R$1199 neste pacote completo que leva voc&ecirc; ao&nbsp;<strong>Snowland Parque de Neve</strong>!</li><li>Passagens a&eacute;reas para Porto Alegre, saindo de S&atilde;o&nbsp;Paulo, Campinas, Rio de Janeiro, Bras&iacute;lia, Belo Horizonte, Aracaju, Fortaleza, Recife, Jo&atilde;o Pessoa, Salvador, Vit&oacute;ria, Campo Grande, Curitiba e Florian&oacute;polis.</li><li>At&eacute; 7 noites em Gramado, na Pousada Casa de Veneza, ou similar, com caf&eacute; da manh&atilde; incluso.</li><li>Voc&ecirc; merece conforto: o Transfer regular&nbsp;aeroporto POA/ Serra Ga&uacute;cha/ Aeroporto POA garante sua sa&iacute;da e chegada &agrave; cidade com tranq&uuml;ilidade.</li><li>Descubra as milhares formas de se divertir na neve! Aproveite o transfer at&eacute; a mais nova atra&ccedil;&atilde;o de Gramado, o&nbsp;<strong>Snowland</strong>, primeiro<span>&nbsp;<strong>parque de neve</strong></span>&nbsp;das Am&eacute;ricas!</li><li>Agora neva em Gramado o ano todo. No&nbsp;<strong>Snowland</strong>&nbsp;voc&ecirc; poder&aacute; se aventurar esquiando, praticando snowboard, brincar com a neve, fazer seu boneco de neve e muito mais!</li><li>E Mais! Cliente INNBat&iacute;vel poder&aacute; adquirir diretamente com a operadora no ato da reserva o passaporte com 45% de desconto para as 4 atra&ccedil;&otilde;es ( Museu de Cera - Dreamland + Museu do Autom&oacute;vel - Hollywood Dream Cars + Super Carros + Harley Motor Show), de R$120 por R$65.</li><li>Na Serra Ga&uacute;cha voc&ecirc; tamb&eacute;m pode fazer um pesseio pelo Vale dos Vinhedos, e visitar as conceituad&iacute;ssimas vin&iacute;colas Salton e Miolo e ainda saborear deliciosas refei&ccedil;&otilde;es com a tradicional culin&aacute;ria italiana. &Eacute; uma del&iacute;cia!</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Confira a pousada em Gramado:</li></ul><p><a href="http://www.pousadacasadeveneza.com.br/index.php" target="_blank">http://www.pousadacasadeveneza.com.br/index.php</a></p><ul><li>Tem alguma d&uacute;vida? Mande um email para&nbsp;<a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>&nbsp;que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-14 11:20:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/kk1ig6uobj4tdk0frpqbl9ohmryqbd2v.jpg,normal:/assets/uploads/images/offers/cover/normal/y2utxptysmfrwsmrigr26wtniwkqtuyh.jpg,thumb:/assets/uploads/images/offers/cover/thumb/kbvhxqynbmlcouhquhkyppfatsqhftzs.jpg,preview:/assets/uploads/images/offers/cover/preview/ivctonqb8qlrkf8yw6tkd74eh6dpimcz.jpg', NULL, NULL, NULL, '<iframe width="500" height="450" src="//www.youtube.com/embed/TtUadO4MODY" frameborder="0" allowfullscreen></iframe>', 1, 99, '2013-11-27 11:39:29', '2013-11-27 14:15:08'),
	(784, 1, 1, 'Tirolesa em Florianópolis - SC', 'Tirolesa | Guia | Equipamentos', 'Tirolesa em Florianópolis - SC', 'Convide seus amigos para uma aventura radical e emocionante!', '', 'Tirolesa | Guia | Equipamentos', 'tirolesa-em-florianopolis-sc', 1, '<p><span style="text-decoration: underline;">Passeio</span></p><ul><li>V&aacute;lido para 1 descida de Tirolesa de R$70 por R$35, incluso guia e equipamentos.</li><li>Utilize seu cupom de 18/11/13 a 31/05/14. Reservas mediante disponibilidade (m&iacute;nimo 5 pessoas por sa&iacute;da) e condi&ccedil;&otilde;es clim&aacute;ticas.</li><li><strong>V&aacute;lido exclusivamente para 1 pessoa, acima de 18 anos.</strong></li><li>Sem limite de compra. Compre quantos cupons quiser.</li><li>N&atilde;o inclui estacionamento (R$15 por ve&iacute;culo), a ser pago no local.</li><li>&Eacute; necess&aacute;rio realizar reserva.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Fa&ccedil;a sua reserva atrav&eacute;s do e-mail <a href="mailto:reservas@engenhoecopark.com.br">reservas@engenhoecopark.com.br</a> anexando o cupom.</li><li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada a disponibilidade de hor&aacute;rios, n&uacute;mero m&iacute;nimo de 5 pessoas por sa&iacute;da e condi&ccedil;&otilde;es clim&aacute;ticas.</li><li>&Eacute; permitido fazer 01 reagendamento com, no m&iacute;nimo, 24h de anteced&ecirc;ncia.</li><li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es </strong><strong>ligue: (48) 3269-7000.</strong></li><li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li></ul>', '<ul><li>Economize R$35 em uma aventura de tirar o f&ocirc;lego no Hotel Engenho Eco Park.</li><li>A tirolesa mais alta do Brasil possui 220 metros e est&aacute; localizada no bairro Rio Vermelho em Florian&oacute;polis &ndash; SC.</li><li>Aventure-se com seguran&ccedil;a, equipamentos adequados e guias qualificados e experientes.</li><li>Esta aventura pode ser praticada por iniciantes.</li><li>N&atilde;o se esque&ccedil;a do protetor solar e repelente, use roupa leve e t&ecirc;nis para a caminhada de 35 minutos at&eacute; o ponto de descida.</li><li>Floripa permite a pr&aacute;tica do esporte com uma espetacular vista.</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-18 00:00:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/60s5ddr7wfqlntmtvz8lemgsdwnmbc0z.jpg,normal:/assets/uploads/images/offers/cover/normal/zfjjkzm6wc92plqbjmil1sfqyjexouzd.jpg,thumb:/assets/uploads/images/offers/cover/thumb/l0q78ekjqawjopeftye4gg5hgqp5bfgr.jpg,preview:/assets/uploads/images/offers/cover/preview/lis5digfhdbyzpta6gbdzbve0he7took.jpg', NULL, NULL, NULL, '', 6, 99, '2013-11-27 11:39:29', '2013-11-27 14:15:21'),
	(785, 1, 1, 'Balneário Camboriú - SC', 'Aéreo saída SP | Beto Carrero World | 3 Noites', 'Balneário Camboriú - SC', 'Divirta-se como uma criança no Parque Beto Carrero e ainda hospede-se na cidade que virou referência de lazer no litoral catarinense!', '', 'Aéreo saída SP | Beto Carrero World | 3 Noites', 'balneario-camboriu-sc', 1, '<p><span style="text-decoration: underline;">Pacote de Viagem</span></p><ul><li>Viaje em uma das seguintes datas:</li></ul><p><strong>Sa&iacute;da S&atilde;o Paulo</strong></p><p><strong>Op&ccedil;&atilde;o 1:</strong> Ida 10/01/14 (previs&atilde;o de sa&iacute;da 20:55h e chegada 22:10h) e Volta 13/01/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:56h) .</p><p><strong>Op&ccedil;&atilde;o 2: </strong>Ida 17/01/14 (previs&atilde;o de sa&iacute;da 18h e chegada 19h) e Volta 20/01/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h) .</p><p><strong>Op&ccedil;&atilde;o 3:</strong> Ida 24/01/14 (previs&atilde;o de sa&iacute;da 18h e chegada 19h) e Volta 27/01/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h) .</p><p><strong>Op&ccedil;&atilde;o 4: </strong>Ida 31/01/14 (previs&atilde;o de sa&iacute;da 20:55h e chegada 22:10h) e Volta 03/02/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 5: </strong>Ida 07/02/14 (previs&atilde;o de sa&iacute;da 13:25h e chegada 14:20h) e Volta 10/02/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 6: </strong>Ida 14/02/14 (previs&atilde;o de sa&iacute;da 20:55h e chegada 22:10h) e Volta 17/02/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 7: </strong>Ida 21/02/14 (previs&atilde;o de sa&iacute;da 20:55h e chegada 22:10h) e Volta 24/02/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 8: </strong>Ida 07/03/14 (previs&atilde;o de sa&iacute;da 18h e chegada 19h) e Volta 10/03/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 9: </strong>Ida 14/03/14 (previs&atilde;o de sa&iacute;da 18h e chegada 19h) e Volta 17/03/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 10: </strong>Ida 21/03/14 (previs&atilde;o de sa&iacute;da 20:55h e chegada 22:10h) e Volta 24/03/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p><strong>Op&ccedil;&atilde;o 11: </strong>Ida 28/03/14 (previs&atilde;o de sa&iacute;da 18h e chegada 19h) e Volta 31/03/14 (previs&atilde;o de sa&iacute;da 07:48h e chegada 08:55h).</p><p>&nbsp;</p><ul><li>Ao clicar em &ldquo;Comprar&rdquo; escolha o per&iacute;odo da sua viagem.</li><li>O pacote inclui: Passagens a&eacute;reas para Navegantes saindo de S&atilde;o Paulo + transfer aeroporto Navegantes/Balne&aacute;rio Cambori&uacute;/aeroporto Navegantes + 3 noites de hospedagem na Pousada Belveder, ou similar + Caf&eacute; da manh&atilde; + Transfer para o Parque Beto Carrero World</li><li>Cia. A&eacute;rea Gol, na classe econ&ocirc;mica promocional, podendo ser alterada conforme disponibilidade.</li><li>V&aacute;lido exclusivamente para 1 pessoa, com acomoda&ccedil;&atilde;o em Quarto Duplo. Caso viaje sozinho, &eacute; obrigat&oacute;ria a troca por Quarto Single, mediante o pagamento de taxa extra de R$250,&nbsp;<span>diretamente &agrave; operadora, no momento da reserva.</span></li><li>N&atilde;o inclui taxas de embarque e emiss&atilde;o (R$150 por pessoa), que dever&atilde;o ser pagas diretamente &agrave; operadora, no momento da reserva.</li><li>Obrigat&oacute;rio Seguro Viagem, que dever&aacute; ser adquirido diretamente com a operadora. Cliente INNBat&iacute;vel tem desconto especial: R$35 para todo o per&iacute;odo.</li><li>N&atilde;o inclui despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, ingresso ao parque, restaurante e outros consumos n&atilde;o citados na oferta.</li><li>Para 1 crian&ccedil;a com at&eacute; 2 anos incompletos, acompanhada de 2 adultos pagantes, ser&aacute; cobrada apenas taxa de R$185. Para crian&ccedil;a com idade a partir de 2 anos, ser&aacute; necess&aacute;ria a aquisi&ccedil;&atilde;o de um novo cupom.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Preencha e envie o formul&aacute;rio de reserva at&eacute; o dia 27/11/13, atrav&eacute;s do site <a href="http://www.tourinn.com.br/?url=compra_coletiva"><strong>http://www.tourinn.com.br/?url=compra_coletiva</strong></a>.</li><li>Formul&aacute;rios enviados ap&oacute;s esta data sofrer&atilde;o altera&ccedil;&otilde;es nos valores e nas condi&ccedil;&otilde;es de reserva.</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva. Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas.</li><li>Os vouchers (documentos) dos servi&ccedil;os contratados ser&atilde;o disponibilizados pela operadora respons&aacute;vel com at&eacute; 48 horas de anteced&ecirc;ncia &agrave; data de embarque. Eles ser&atilde;o enviados por e-mail.</li><li>N&atilde;o h&aacute; direito de remarca&ccedil;&atilde;o em caso de n&atilde;o comparecimento ou perda do v&ocirc;o.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es entre em contato atrav&eacute;s do e-mail: </strong><a href="mailto:reservas@tourinn.com.br"><strong>reservas@tourinn.com.br</strong></a><strong> ou ligue (11) 3614-9010, (48) 3206-0902, (48) 3206-0894 e (48) 3369-9083, de segunda a sexta, das 9h &agrave;s 17h.</strong></li><li>As taxas e seguro viagem poder&atilde;o ser parcelados em at&eacute; 12x no cart&atilde;o de cr&eacute;dito diretamente com a operadora.</li></ul><p><span style="text-decoration: underline;">Momento do Embarque</span></p><ul><li>Para embarque &eacute; necess&aacute;rio apresentar a carteira de identidade nacional (RG) emitida pela Secretaria de Seguran&ccedil;a P&uacute;blica, original, em bom estado, na cor verde, com no m&aacute;ximo 10 anos de emiss&atilde;o, Carteira Nacional de Habilita&ccedil;&atilde;o (CNH), Carteira Profissional emitida pelos Conselhos, Carteira Profissional original ou Certificado de Reservista. A documenta&ccedil;&atilde;o &eacute; de exclusiva responsabilidade do passageiro.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva; em caso de cancelamento, n&atilde;o haver&aacute; a devolu&ccedil;&atilde;o do valor pago.</li><li>Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas e o cancelamento resultar&aacute; na perda total do cupom.</li></ul>', '<ul><li>Economize R$782 neste pacote completo!</li><li>Passagens a&eacute;reas para Navegantes, saindo de S&atilde;o Paulo.</li><li>3 noites em Balne&aacute;rio Cambori&uacute; + Caf&eacute; da manh&atilde; na Pousada Belveder, ou similar.</li><li>Para sua comodidade o transfer aeroporto Navegantes/Balne&aacute;rio Cambori&uacute;/aeroporto Navegantes est&aacute; incluso.</li><li>V&aacute; de transfer ao Parque Beto Carrero World e divirta-se com toda a seguran&ccedil;a e tranquilidade.</li><li>O maior parque de divers&otilde;es da Am&eacute;rica Latina espera por voc&ecirc; e sua fam&iacute;lia com op&ccedil;&otilde;es de brinquedos e atra&ccedil;&otilde;es para todas as idades.</li><li>Balne&aacute;rio Cambori&uacute; possui praias paradis&iacute;acas e um forte com&eacute;rcio com atendimento de qualidade para que sua estadia seja agrad&aacute;vel.</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Confira a pousada em Balne&aacute;rio Cambori&uacute;</li></ul><p><a href="http://www.belveder.com.br/">http://www.belveder.com.br/</a></p><ul><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-18 00:00:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/vpmoqxy7gqzvgxzgz9vvrbw3e0hdfcbq.jpg,normal:/assets/uploads/images/offers/cover/normal/l7wdu5sqdh4bxm1lt1ttosgxudq6bcr8.jpg,thumb:/assets/uploads/images/offers/cover/thumb/ejrwmaxwluk1pibn6cpn5id17htcag2x.jpg,preview:/assets/uploads/images/offers/cover/preview/bfhu4sfa1ob93nqbsq7y7s7hsmleuga5.jpg', NULL, NULL, NULL, '', 15, 99, '2013-11-27 11:39:29', '2013-11-27 14:15:34'),
	(786, 1, 1, 'Campos do Jordão - SP', '2 pessoas | 2 diárias | Passeio', 'Campos do Jordão - SP', 'Oferta Imperdível para a charmosa cidade da serra paulista! Agora é só escolher e curtir.', '', '2 pessoas | 2 diárias | Passeio', 'campos-do-jordao-sp-1', 1, '<p><span style="text-decoration: underline;">Hospedagem</span></p><ul><li>Utilize seu cupom em dias de semana no per&iacute;odo de 19/11/13 a 30/05/14, ou em finais de semana no per&iacute;odo de 03/01/14 a 31/03/14, mediante disponibilidade.</li><li>Ao clicar em &ldquo;comprar&rdquo; escolha a op&ccedil;&atilde;o:</li></ul><p><strong>Op&ccedil;&atilde;o 1:</strong>&nbsp;2 di&aacute;rias em dias de semana (de 19/11/13 a 30/05/14) + caf&eacute; da manh&atilde; de R$380 por R$159.</p><p><strong>Op&ccedil;&atilde;o 2:</strong>&nbsp;2 di&aacute;rias em fins de semana (de 03/01/14 a 31/03/14) + caf&eacute; da manh&atilde; de R$540 por R$239.</p><ul><li>V&aacute;lido exclusivamente para 2 pessoas, com acomoda&ccedil;&atilde;o em su&iacute;te.</li><li>Sem limite de compra. Compre quantos cupons quiser.</li><li>Incluso Passeio no parque ecol&oacute;gico Bosque do Silencio, localizado a 1,2km do centro do Capivari.</li><li>Desconto de 40% no rod&iacute;zio de fondue no restaurante &ldquo;O Patriota&rdquo;.</li><li>Desconto de 15% no passeio de quadriciclo (para 2 pessoas) no Quadmania.</li><li>Desconto de 20% no almo&ccedil;o para duas pessoas no restaurante Cantinho da Serra.</li><li><strong>N&atilde;o inclui taxa de servi&ccedil;o (10% sobre o valor da oferta) e despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante e outros consumos n&atilde;o citados na oferta, que dever&atilde;o ser pagos diretamente na pousada.</strong></li><li>1 crian&ccedil;a com at&eacute; 5 anos possui hospedagem cortesia (na mesma su&iacute;te dos pais). Para crian&ccedil;as de 5 a 12 anos, &eacute; cobrado 30% do valor do cupom e crian&ccedil;as acima 12 anos, &eacute; cobrado 50% do valor do cupom para hospedagem na mesma su&iacute;te dos pais.</li><li>Check-in a partir das 14h e check-out at&eacute; as 12h.</li><li>Para hospedagem de mais pessoas ou aquisi&ccedil;&atilde;o de di&aacute;ria extra, consulte a pousada.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Fa&ccedil;a sua reserva atrav&eacute;s do e-mail&nbsp;<a href="mailto:pousadamarins@globo.com">pousadamarins@globo.com</a>&nbsp;informando o c&oacute;digo do cupom.</li><li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada a disponibilidade da pousada para a oferta.</li><li>&Eacute; permitido fazer 01 reagendamento com, no m&iacute;nimo, 07 dias de anteced&ecirc;ncia.</li><li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es ligue:&nbsp;(12) 3662-4030.</strong></li><li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute;&nbsp;n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email&nbsp;<a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li></ul>', '<ul><li>Economize at&eacute; R$301 em 2 Di&aacute;rias para 2 pessoas na aconchegante Pousada Marins.</li><li>Utilize em fins de semana ou durante a semana, escolha!</li><li>A pousada possui uma elegante decora&ccedil;&atilde;o r&uacute;stica e oferece um &oacute;timo atendimento para lhe receber. Voc&ecirc; estar&aacute; em uma &oacute;tima localiza&ccedil;&atilde;o, pr&oacute;ximo ao centrinho de Capivari.</li><li>Curta o passeio ao Parque Ecol&oacute;gico Bosque do Sil&ecirc;ncio e divirta-se em meio &agrave; natureza. O parque possui circuito de arvorismo adulto e infantil, al&eacute;m de op&ccedil;&otilde;es de paintball e minigolfe para garantir a alegria de toda a sua fam&iacute;lia!</li><li>E mais! Desconto de 40% no rod&iacute;zio de fondue no restaurante &ldquo;O Patriota&rdquo;.</li><li>Desconto de 15% no passeio de quadriciclo (para 2 pessoas) no Quadmania.</li><li>Desconto de 20% no almo&ccedil;o para duas pessoas no restaurante Cantinho da Serra.</li><li>Inicie o dia cheio de energia com um saboroso caf&eacute; da manh&atilde; repleto de op&ccedil;&otilde;es deliciosas para voc&ecirc;!</li><li>Uma dica imperd&iacute;vel &eacute; o passeio de telef&eacute;rico no Morro do Elefante: v&aacute; at&eacute; l&aacute; em cima e confira uma vista panor&acirc;mica da cidade!</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li></ul><ul><li>Tem alguma d&uacute;vida? Mande um email para&nbsp;<a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>&nbsp;que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-19 16:47:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/udfla0ctq3fhmt7kz5kvr9cqa6pcbrek.jpg,normal:/assets/uploads/images/offers/cover/normal/rbwykotsttdbj9rune70kzr6ryretwal.jpg,thumb:/assets/uploads/images/offers/cover/thumb/4jdop6smyfslch1ux3ape2xc0hfilx1j.jpg,preview:/assets/uploads/images/offers/cover/preview/erbptrncm3eaiofdrmkmtk482yyr5rqo.jpg', NULL, NULL, NULL, '', 17, 99, '2013-11-27 11:39:29', '2013-11-27 14:15:46'),
	(787, 1, 1, 'Campos do Jordão - SP', 'Natal | Ano Novo | Carnaval', 'Campos do Jordão - SP', 'Desfrute de todo o encanto da serra paulista. Escolha Natal, Réveillon ou Carnaval e divirta-se!', '', 'Natal | Ano Novo | Carnaval', 'campos-do-jordao-sp', 1, '<p><span style="text-decoration: underline;">Hospedagem</span></p><ul><li>Utilize seu cupom de 21/11/13 a 30/04/14 (exceto p&aacute;scoa), mediante disponibilidade.</li><li>Ao clicar em &ldquo;comprar&rdquo; escolha a op&ccedil;&atilde;o:</li></ul><p><strong>Op&ccedil;&atilde;o 1:</strong> 2 di&aacute;rias durante a semana de 21/11/13 a 30/04/14 (exceto natal, ano novo, carnaval e p&aacute;scoa)&nbsp;+ caf&eacute; da manh&atilde; de R$420 por R$189.</p><p><strong>Op&ccedil;&atilde;o 2:</strong> 2 di&aacute;rias em finais de semana de&nbsp;21/11/13 a 30/04/14 (exceto natal, ano novo, carnaval e p&aacute;scoa)&nbsp;+ caf&eacute; da manh&atilde; de R$540 por R$239.</p><p><strong>Op&ccedil;&atilde;o 3:</strong> 3 di&aacute;rias no Natal ou Ano Novo + caf&eacute; da manh&atilde; de R$870 por R$419.</p><p><strong>Op&ccedil;&atilde;o 4:</strong> 5 di&aacute;rias no Carnaval + caf&eacute; da manh&atilde; de R$1800 por R$899.</p><ul><li>V&aacute;lido exclusivamente para 2 pessoas, com acomoda&ccedil;&atilde;o em su&iacute;te standard.</li><li>Sem limite de compra. Compre quantos cupons quiser.</li><li><strong>N&atilde;o inclui taxa de servi&ccedil;o e despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, </strong><strong>estacionamento</strong><strong> e outros consumos n&atilde;o citados na oferta, a ser pago no </strong><strong>check-out.</strong></li><li>1 crian&ccedil;a com at&eacute; 5 anos possui hospedagem cortesia (na mesma su&iacute;te dos pais).</li><li>Check-in a partir das 14h e Late check-out at&eacute; as 18h.</li><li>Para hospedagem de mais pessoas ou aquisi&ccedil;&atilde;o de di&aacute;ria extra, consulte a pousada.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Fa&ccedil;a sua reserva atrav&eacute;s do e-mail <a href="mailto:contato@pousadamanacadaserra.net">contato@pousadamanacadaserra.net</a> informando o c&oacute;digo do cupom.</li><li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada a disponibilidade da pousada para a oferta.</li><li>&Eacute; permitido fazer 01 reagendamento com, no m&iacute;nimo, 07 dias de anteced&ecirc;ncia.</li><li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es ligue: </strong><strong>(12) 3663-3155.</strong></li><li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li></ul>', '<ul><li>Economize at&eacute; R$901 em at&eacute; 5 Di&aacute;rias para 2 pessoas na Pousada Manac&aacute; da Serra.</li><li>Utilize no Natal, Ano Novo, Carnaval, fim de semana ou durante a semana, escolha!</li><li>Um delicioso caf&eacute; da manh&atilde; espera por voc&ecirc;.</li><li>A Pousada Manac&aacute; da Serra possui &aacute;rea social com sala de TV, sal&atilde;o de jogos, American Bar, internet WIFI e canais SKY.</li><li>A pousada est&aacute; localizada a 1700 metros do centro.</li><li>Localizada na Serra da Mantiqueira, Campos do Jord&atilde;o tem o gostoso clima de montanha, reconhecido como um dos melhores do mundo.</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-21 00:00:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/1npkfprihx3sioaiulciodjlsdhhurfy.jpg,normal:/assets/uploads/images/offers/cover/normal/itj69xjabqhpxxjvgaqcnkuqnnsbjwpf.jpg,thumb:/assets/uploads/images/offers/cover/thumb/wru4imcpjfqz6tpzgzquto2jivuttevc.jpg,preview:/assets/uploads/images/offers/cover/preview/1vcytaeqszeek30ptd9au4sbdw6o4rfw.jpg', NULL, NULL, NULL, '', 9, 99, '2013-11-27 11:39:29', '2013-11-27 14:15:56'),
	(788, 1, 1, 'Mergulho em Bombinhas - SC', 'Equipamento | Instrutor', 'Mergulho em Bombinhas - SC', 'Aventure-se na Capital do Mergulho pagando muito pouco. Traga seus amigos para um mergulho inesquecível!', '', 'Equipamento | Instrutor', 'mergulho-em-bombinhas-sc', 1, '<p><span style="text-decoration: underline;">Passeio</span></p><ul><li>V&aacute;lido para 1 Mergulho de Batismo na praia da Sepultura ou Estaleiro (com cilindro e dura&ccedil;&atilde;o de 30 minutos) de R$180 por R$89, incluso equipamento e instrutor qualificado.</li><li>Utilize seu cupom de 21/11/13 a 30/04/14 (exceto de 25/12/13 a 01/01/14, de 01/03/14 a 05/03/14 e de 16/04/14 a 20/04/14), mediante disponibilidade.</li></ul><ul><li>V&aacute;lido exclusivamente para 1 pessoa. Idade m&iacute;nima: 08 anos.</li><li>Sem limite de compra. Compre quantos cupons quiser.</li><li>N&atilde;o &eacute; necess&aacute;rio experi&ecirc;ncia ou ter realizado curso de mergulho.</li><li><strong>N&atilde;o inclui taxa de trapiche de R$10 por pessoa. Estacionamento, servi&ccedil;o de fotografia e diplomas n&atilde;o est&atilde;o inclusos na oferta.</strong></li><li>O mergulho &eacute; contraindicado para pessoas que sofram de epilepsia e gestantes.</li><li>Sa&iacute;das di&aacute;rias de Bombinhas, no endere&ccedil;o da HyBrazil: Av. Vereador Manoel Jos&eacute; dos Santos, 205, Centro, Bombinhas, SC.</li><li>&Eacute; necess&aacute;rio fazer reserva.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Fa&ccedil;a sua reserva com no m&iacute;nimo 07 dias de anteced&ecirc;ncia, atrav&eacute;s do e-mail <a href="mailto:promoinn@hybrazil.com.br">promoinn@hybrazil.com.br</a> informando o c&oacute;digo do cupom.</li><li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada a disponibilidade de hor&aacute;rios e condi&ccedil;&otilde;es clim&aacute;ticas e mar&iacute;timas.</li><li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es </strong><strong>ligue: (47) 3369-0025.</strong></li><li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li></ul>', '<ul><li>Economize R$91 em um delicioso mergulho em Bombinhas - SC</li><li>V&aacute; para a capital do mergulho ecol&oacute;gico e aprenda a mergulhar de cilindro junto com profissionais experientes e qualificados.</li><li>Mergulho de batismo na praia da Sepultura ou Estaleiro.</li><li>N&atilde;o &eacute; necess&aacute;rio ter experi&ecirc;ncia ou curso de mergulho.</li><li>Fique tranquilo, pois ter&aacute; um briefing explicativo e ser&aacute; feito uma adapta&ccedil;&atilde;o aos equipamentos no local do mergulho.</li><li>Bombinhas possui diferentes locais de mergulho, os quais fazem parte de um importante centro de estudos cient&iacute;ficos de fauna e flora marinha. Conhe&ccedil;a!</li><li>Durante 30 minutos presencie as riquezas do mar de Bombinhas.</li><li>Mergulhe com uma das tr&ecirc;s maiores empresas de mergulho do munic&iacute;pio de Bombinhas</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-21 00:00:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/hjzl5dojp3qig56oh03yyovuklltynh1.jpg,normal:/assets/uploads/images/offers/cover/normal/ikf06tpkxmye7rlz1ebcdkdhdljtzz1k.jpg,thumb:/assets/uploads/images/offers/cover/thumb/tqohdmo9sch64rulghiwdltmfysygujt.jpg,preview:/assets/uploads/images/offers/cover/preview/yxftbdbb98xbveu5zduej0fnuwtto2ed.jpg', NULL, NULL, NULL, '', 0, 99, '2013-11-27 11:39:29', '2013-11-27 14:16:11'),
	(789, 1, 1, 'Praia do Rosa - SC', 'Até 5 diárias | 2 pessoas | Café da manhã', 'Praia do Rosa - SC', 'Leve quem quiser para dias divertidos na deliciosa Praia do Rosa.', '', 'Até 5 diárias | 2 pessoas | Café da manhã', 'praia-do-rosa-sc', 1, '<p><span style="text-decoration: underline;">Hospedagem</span></p><ul><li>Utilize seu cupom de 21/11/13 a 22/12/13, 17/01/14 a 27/02/14 e de 07/03/14 a 31/10/14 (exceto feriados prolongados), mediante disponibilidade.</li><li>Ao clicar em &ldquo;comprar&rdquo; escolha a op&ccedil;&atilde;o:</li></ul><p><strong>Op&ccedil;&atilde;o 1:</strong> 2 di&aacute;rias para 2 pessoas + caf&eacute; da manh&atilde; de 21/11/13 a 22/12/13 e de 07/03/14 a 31/10/14&nbsp;de R$400 por R$199.</p><p><strong>Op&ccedil;&atilde;o 2:</strong> 3 di&aacute;rias para 2 pessoas + caf&eacute; da manh&atilde; de 21/11/13 a 22/12/13 e de 07/03/14 a 31/10/14 de R$600 por R$298.</p><p><strong>Op&ccedil;&atilde;o 3:</strong> 5 di&aacute;rias para 2 pessoas + caf&eacute; da manh&atilde; de 17/01/14 a 27/02/14 (Alta Temporada)&nbsp;de R$1250 por R$599.</p><p>&nbsp;</p><ul><li>V&aacute;lido exclusivamente para 2 pessoas, com acomoda&ccedil;&atilde;o em su&iacute;tes tem&aacute;ticas havaianas.</li><li>Sem limite de compra. Compre quantos cupons quiser.</li><li><strong>N&atilde;o inclui taxa de servi&ccedil;o e despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, e outros consumos n&atilde;o citados na oferta, a ser pago no </strong><strong>check-out.</strong></li><li>1 crian&ccedil;a com at&eacute; 5 anos possui hospedagem cortesia (na mesma su&iacute;te dos pais).</li><li>Check-in a partir das 14h e check-out at&eacute; &agrave;s 12h.</li><li>Para hospedagem de mais pessoas ou aquisi&ccedil;&atilde;o de di&aacute;ria extra, consulte a pousada.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Fa&ccedil;a sua reserva atrav&eacute;s do e-mail <a href="mailto:alohapraiadorosa@hotmail.com">alohapraiadorosa@hotmail.com</a> informando o c&oacute;digo do cupom.</li><li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada a disponibilidade da pousada para a oferta.</li><li>&Eacute; permitido fazer 01 reagendamento com, no m&iacute;nimo, 07 dias de anteced&ecirc;ncia.</li><li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es ligue: </strong><strong>(48) 3354-0229.</strong></li><li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li></ul>', '<ul><li>Economize at&eacute; R$651 em at&eacute; 5 Di&aacute;rias para 2 pessoas na Pousada Aloha Beach House.</li><li>A pousada possui piscina com hidromassagem, deck e solarium, quiosque com cozinha completa, servi&ccedil;o de quarto, estacionamento e WIFI.</li><li>Um saboroso caf&eacute; da manh&atilde; para come&ccedil;ar o dia de bem com a vida, junto com atendimento personalizado e de qualidade aguardam por voc&ecirc;.</li><li>Hospede-se nas charmosas e confort&aacute;veis su&iacute;tes tem&aacute;ticas havaianas.</li><li>Divirta-se e encante-se com a lind&iacute;ssima Praia do Rosa, em Santa Catarina.</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-21 00:00:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/mfcihq7u2vzoxm5ivq4r8hob4mx3nvn2.jpg,normal:/assets/uploads/images/offers/cover/normal/xiiq1vvruaw8ppafxupwappqpzoaxius.jpg,thumb:/assets/uploads/images/offers/cover/thumb/oaacdj8bjfcmk2euqgl8uxszpbg37hyb.jpg,preview:/assets/uploads/images/offers/cover/preview/jlbkgbf4bqz0p4pevgf2e7ape0pvyrso.jpg', NULL, NULL, NULL, '', 10, 99, '2013-11-27 11:39:29', '2013-11-27 14:16:32'),
	(790, 1, 1, 'Buenos Aires - ARG', 'Réveillon | Aéreo | 3 noites | Tour de Compras', 'Buenos Aires - ARG', 'Um Réveillon diferente e emocionante aguarda por você!', '', 'Réveillon | Aéreo | 3 noites | Tour de Compras', 'buenos-aires-arg', 1, '<p><span style="text-decoration: underline;">Pacote de Viagem</span></p><ul><li>Viaje na seguinte data:</li></ul><p><span style="text-decoration: underline;"><strong>Sa&iacute;da S&atilde;o Paulo</strong></span></p><p>Ida 31/12/13 (previs&atilde;o de sa&iacute;da 08:10h e chegada 10:05h) e Volta 03/01/14 (previs&atilde;o de sa&iacute;da 16:20h e chegada 20:00h) de R$2992 por R$999.</p><ul><li>O pacote inclui: Passagens a&eacute;reas para Buenos Aires (Ezeiza) saindo de S&atilde;o Paulo + 3 noites de hospedagem no Hotel Monarca, ou similar + caf&eacute; da manh&atilde; + City Tour + Tour de Compras + 1 CD de Tango por apartamento.</li><li>Cia. A&eacute;rea Tam, Gol, Avianca ou Azul, na classe econ&ocirc;mica promocional, podendo ser alterada conforme disponibilidade.</li><li>V&aacute;lido exclusivamente para 1 pessoa, com acomoda&ccedil;&atilde;o em Quarto Duplo. Caso viaje sozinho, &eacute; obrigat&oacute;ria a troca por Quarto Single, mediante o pagamento de taxa extra de U$150, diretamente &agrave; operadora, no momento da reserva.</li><li>N&atilde;o inclui taxas de embarque e emiss&atilde;o (U$198 por pessoa), que dever&atilde;o ser pagas diretamente &agrave; operadora, no momento da reserva.</li><li>Obrigat&oacute;rio Seguro Viagem, que dever&aacute; ser adquirido diretamente com a operadora no valor promocional de U$48 para todo o per&iacute;odo.</li><li>N&atilde;o inclui despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, e outros consumos n&atilde;o citados na oferta.</li><li>Para 1 crian&ccedil;a com at&eacute; 2 anos incompletos, acompanhada de 2 adultos pagantes, ser&aacute; cobrada apenas taxa de U$350 (incluso taxas e seguro viagem). Para crian&ccedil;a com idade a partir de 2 anos, ser&aacute; necess&aacute;ria a aquisi&ccedil;&atilde;o de um novo cupom.</li><li>Pacote calculado com base no c&acirc;mbio de R$2,50, sujeito a altera&ccedil;&atilde;o.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Preencha e envie o formul&aacute;rio de reserva imediatamente ap&oacute;s a compra, atrav&eacute;s do site <a href="http://www.tourinn.com.br/?url=compra_coletiva"><strong>http://www.tourinn.com.br/?url=compra_coletiva</strong></a>.</li><li>Formul&aacute;rios enviados ap&oacute;s esta data sofrer&atilde;o altera&ccedil;&otilde;es nos valores e nas condi&ccedil;&otilde;es de reserva.</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva. Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas.</li><li>Os vouchers (documentos) dos servi&ccedil;os contratados ser&atilde;o disponibilizados pela operadora respons&aacute;vel com at&eacute; 48 horas de anteced&ecirc;ncia &agrave; data de embarque. Eles ser&atilde;o enviados por e-mail.</li><li>N&atilde;o h&aacute; direito de remarca&ccedil;&atilde;o em caso de n&atilde;o comparecimento ou perda do v&ocirc;o.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es entre em contato atrav&eacute;s do e-mail: </strong><a href="mailto:reservas@tourinn.com.br"><strong>reservas@tourinn.com.br</strong></a><strong> ou ligue (11) 3614-9010, (48) 3206-0902, (48) 3206-0894 e (48) 3369-9083, de segunda a sexta, das 9h &agrave;s 17h.</strong></li><li>As taxas e seguro viagem poder&atilde;o ser parcelados em at&eacute; 12x no cart&atilde;o de cr&eacute;dito diretamente com a operadora.</li></ul><p><span style="text-decoration: underline;">Momento do Embarque</span></p><ul><li>Para entrar na Argentina n&atilde;o &eacute; necess&aacute;rio Passaporte ou Visto, basta apresentar a carteira de identidade nacional (RG) emitida pela Secretaria de Seguran&ccedil;a P&uacute;blica, original, em bom estado, na cor verde, com no m&aacute;ximo 10 anos de emiss&atilde;o. A documenta&ccedil;&atilde;o &eacute; de exclusiva responsabilidade do passageiro.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 07 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 07 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva; em caso de cancelamento, n&atilde;o haver&aacute; a devolu&ccedil;&atilde;o do valor pago.</li><li>Ap&oacute;s a emiss&atilde;o do bilhete, o cancelamento resultar&aacute; na perda total do cupom.</li></ul>', '<ul><li>Economize R$1993 neste pacote completo de R&eacute;veillon!</li><li>Passagens a&eacute;reas para Buenos Aires, saindo de S&atilde;o Paulo.</li><li>3 noites em Buenos Aires + caf&eacute; da manh&atilde; no Hotel Monarca, ou similar.</li><li>Prepare-se para conhecer o que Buenos Aires tem de mais interessante com o City Tour.</li><li>Entre no delicioso ritmo de Buenos Aires com um CD de tango.</li><li>Tour de compras tamb&eacute;m est&aacute; incluso no pacote para voc&ecirc; voltar para casa com a mala cheia e um enorme sorriso no rosto.</li><li>Comece 2014 em destino internacional com o p&eacute; direito!</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Confira o hotel em Buenos Aires:</li></ul><p><a href="http://www.monarcahoteles.com/ar/" target="_blank">http://www.monarcahoteles.com/ar/</a></p><ul><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-21 13:30:00', '2013-11-27 09:00:00', 'original:/assets/uploads/images/offers/cover/original/juomvwruaszvlc0tctsyi9r7uwuka5vk.jpg,normal:/assets/uploads/images/offers/cover/normal/vwfh7feunnpzcyo7vkizqsb5x4sgtuzy.jpg,thumb:/assets/uploads/images/offers/cover/thumb/vc11dx6v1vnkqdrwknfrdian7rswctzh.jpg,preview:/assets/uploads/images/offers/cover/preview/kltofjl4iecwafz16uidvszhb8lcnzni.jpg', NULL, NULL, NULL, '<iframe width="500" height="450" src="//www.youtube.com/embed/-felS1pBBdM" frameborder="0" allowfullscreen></iframe>', 3, 99, '2013-11-27 11:39:29', '2013-11-27 14:16:41'),
	(791, 1, 1, 'Foz do Iguaçu - PR', 'Aéreo | Passeios | Tour de Compras', 'Foz do Iguaçu - PR', 'Você em Foz do Iguaçu desfrutando de tudo o que uma viagem precisa para ser inesquecível! Apaixone-se pelas forças das Cataratas, vá as compras e conheça o Parque das Aves.', '', 'Aéreo | Passeios | Tour de Compras', 'foz-do-iguacu-pr', 1, '<p><span style="text-decoration: underline;">Pacote de Viagem</span></p><ul><li>Viaje em uma das seguintes datas:</li></ul><p><strong><span style="text-decoration: underline;">Sa&iacute;da Rio de Janeiro (GIG)</span>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong></p><p><strong>Op&ccedil;&atilde;o 1:</strong>&nbsp;Ida&nbsp;21/03/14 (previs&atilde;o de sa&iacute;da: 13:37h e previs&atilde;o de chegada: 17:40h) e Volta&nbsp;24/03/14&nbsp;(previs&atilde;o de sa&iacute;da: 14:35h e previs&atilde;o de chegada: 18:11h).</p><p><strong>Op&ccedil;&atilde;o 2:</strong>&nbsp;Ida&nbsp;11/04/14 (previs&atilde;o de sa&iacute;da: 10:10h e previs&atilde;o de chegada: 12:13h) e Volta&nbsp;14/04/14&nbsp;(previs&atilde;o de sa&iacute;da: 14:35h e previs&atilde;o de chegada: 18:11h).</p><p><span style="text-decoration: underline;"><strong>Sa&iacute;da S&atilde;o Paulo (CGH)</strong></span></p><p><strong>Op&ccedil;&atilde;o 1:</strong>&nbsp;Ida 14/03/14 (previs&atilde;o de sa&iacute;da: 08:16h e previs&atilde;o de chegada: 11:10h) e Volta&nbsp;17/03/14&nbsp;(previs&atilde;o de sa&iacute;da: 11:40h e previs&atilde;o de chegada: 14:20h).</p><p><strong>Op&ccedil;&atilde;o 2:</strong>&nbsp;Ida 28/03/14 (previs&atilde;o de sa&iacute;da: 08:16h e previs&atilde;o de chegada: 11:10h) e Volta&nbsp;31/03/14&nbsp;(previs&atilde;o de sa&iacute;da: 11:40h e previs&atilde;o de chegada: 14:20h).</p><ul><li>Ao clicar em &ldquo;Comprar&rdquo; escolha a cidade de embarque e o per&iacute;odo da sua viagem.</li><li>O pacote inclui:&nbsp;Passagens a&eacute;reas para Foz do Igua&ccedil;u saindo de S&atilde;o Paulo ou Rio de Janeiro + transfer aeroporto /hotel /aeroporto + 3 noites de hospedagem no hotel Galli Palace Hotel 4 estrelas, ou similar + caf&eacute; da manh&atilde; + Transporte ida e volta para: Cataratas do Igua&ccedil;u (lado Brasileiro), Parque das Aves, Compras no Paraguai e Duty Free Shop na Argentina. N&atilde;o inclui ingresso nas atra&ccedil;&otilde;es.</li><li>Cia. A&eacute;rea&nbsp;Tam, Gol, Avianca ou Azul, na classe econ&ocirc;mica promocional, podendo ser alterada conforme disponibilidade.</li><li>V&aacute;lido exclusivamente para 1 pessoa, com acomoda&ccedil;&atilde;o em&nbsp;Quarto Duplo. Caso viaje sozinho, &eacute; obrigat&oacute;ria&nbsp;a troca por Quarto Single, mediante o pagamento de taxa extra de&nbsp;R$240, diretamente &agrave; operadora, no momento da reserva.</li><li>N&atilde;o inclui taxas de embarque e emiss&atilde;o (R$150 por pessoa), que dever&atilde;o ser pagas diretamente &agrave; operadora, no momento da reserva.</li><li>Obrigat&oacute;rio Seguro Viagem, que dever&aacute; ser adquirido diretamente com a operadora no valor promocional de R$35 para todo o per&iacute;odo.</li><li>N&atilde;o inclui despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, ingressos no passeios e outros consumos n&atilde;o citados na oferta.</li><li>Para 1 crian&ccedil;a com at&eacute;&nbsp;2 anos&nbsp;incompletos, acompanhada de 2 adultos pagantes, ser&aacute; cobrada apenas taxa de&nbsp;R$185. Para crian&ccedil;a com idade a partir de 2&nbsp;anos, ser&aacute; necess&aacute;ria a aquisi&ccedil;&atilde;o de um novo cupom.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute;&nbsp;n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Preencha e envie o formul&aacute;rio de reserva imediatamente ap&oacute;s a compra, atrav&eacute;s do site&nbsp;<a href="http://www.tourinn.com.br/?url=compra_coletiva" target="_blank"><strong>http://www.tourinn.com.br/?url=compra_coletiva</strong></a>.</li><li>Formul&aacute;rios enviados ap&oacute;s esta data sofrer&atilde;o altera&ccedil;&otilde;es nos valores e nas condi&ccedil;&otilde;es de reserva.</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva. Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas.</li><li>Os vouchers (documentos) dos servi&ccedil;os contratados ser&atilde;o disponibilizados pela operadora respons&aacute;vel com at&eacute; 48 horas de anteced&ecirc;ncia &agrave; data de embarque. Eles ser&atilde;o enviados por e-mail.</li><li>N&atilde;o h&aacute; direito de remarca&ccedil;&atilde;o em caso de n&atilde;o comparecimento ou perda do v&ocirc;o.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es entre em contato atrav&eacute;s do e-mail:&nbsp;</strong><a href="mailto:reservas@tourinn.com.br"><strong>reservas@tourinn.com.br</strong></a><strong>&nbsp;ou ligue (11) 3614-9010, (48) 3206-0902, (48) 3206-0894 e (48) 3369-9083, de segunda a sexta, das 9h &agrave;s 17h.</strong></li><li>As taxas e seguro viagem poder&atilde;o ser parcelados em at&eacute; 12x no cart&atilde;o de cr&eacute;dito diretamente com a operadora.</li></ul><p><span style="text-decoration: underline;">Momento do Embarque</span></p><ul><li>Para embarque &eacute; necess&aacute;rio apresentar a carteira de identidade nacional (RG) emitida pela Secretaria de Seguran&ccedil;a P&uacute;blica, original, em bom estado, na cor verde, com no m&aacute;ximo 10 anos de emiss&atilde;o, Carteira Nacional de Habilita&ccedil;&atilde;o (CNH), Carteira Profissional emitida pelos Conselhos, Carteira Profissional original ou Certificado de Reservista. A documenta&ccedil;&atilde;o &eacute; de exclusiva responsabilidade do passageiro.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br"><strong>faleconosco@innbativel.com.br</strong></a>.</li><li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva; em caso de cancelamento, n&atilde;o haver&aacute; a devolu&ccedil;&atilde;o do valor pago.</li><li>Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas e o cancelamento resultar&aacute; na perda total do cupom.</li></ul>', '<ul><li>Economize R$902 neste pacote completo!</li><li>Passagens a&eacute;reas para Foz do Igua&ccedil;u, saindo de S&atilde;o Paulo e Rio de Janeiro.</li><li>3 noites com caf&eacute; da manh&atilde; em Foz do Igua&ccedil;u no hotel Galli Palace Hotel 4 estrelas, que conta com excelente infraestrutura e f&aacute;cil acesso aos principais pontos tur&iacute;sticos.</li><li>Veja de perto&nbsp;as&nbsp;famosas Cataratas do Igua&ccedil;u, um cen&aacute;rio de cart&atilde;o postal, que formam o maior conjunto de quedas d\'&aacute;gua da Terra. Admire toda esta beleza de perto, nas passarelas e mirantes que permitem at&eacute; que voc&ecirc; sinta a for&ccedil;a das &aacute;guas.</li><li>Compras irresist&iacute;veis nos vizinhos Puerto Iguaz&uacute;, Argentina, e Cidade del Este, Paraguai.</li><li>Visita ao Parque das Aves, ideal para quem gosta de apreciar a beleza dos tucanos, araras, periquitos, entre outras das 150 esp&eacute;cies diferentes.</li><li>A oferta ainda contempla transfer de ida e volta para o aeroporto, em&nbsp;Foz&nbsp;do Igua&ccedil;u.</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Confira o hotel em Foz do Igua&ccedil;u:</li></ul><p><a href="http://www.gallipalacehotel.com.br/" target="_blank"><strong>http://www.gallipalacehotel.com.br/</strong></a></p><ul><li>Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br"><strong>faleconosco@innbativel.com.br</strong></a>&nbsp;que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-21 11:42:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/c0ji5cwbnq0prose99s1pr3weoedxcvl.jpg,normal:/assets/uploads/images/offers/cover/normal/hg6gfivroxryr7ucfcul87qcduwx8iju.jpg,thumb:/assets/uploads/images/offers/cover/thumb/0yj8ge3nxh35blarabyi5lt3tkf29cvn.jpg,preview:/assets/uploads/images/offers/cover/preview/ke4q3qmbsevf0mllplme1mkj89r1sugq.jpg', NULL, NULL, NULL, '', 2, 99, '2013-11-27 11:39:29', '2013-11-27 14:16:54'),
	(792, 1, 1, 'Bonito - MS', 'Aéreo SP e RJ | 3 diárias | Café', 'Bonito - MS', 'Bonito possui diversas opções de passeios para sua diversão. Para quem ama a natureza e aventura este é o lugar ideal para passar as férias.', '', 'Aéreo SP e RJ | 3 diárias | Café', 'bonito-ms', 1, '<p><span style="text-decoration: underline;">Pacote de Viagem</span></p><ul><li>Viaje em uma das seguintes datas:</li></ul><p><span style="text-decoration: underline;"><strong>Sa&iacute;da S&atilde;o Paulo de R$1196 por R$598</strong></span></p><p><strong>Op&ccedil;&atilde;o 1:</strong> Ida 05/12/13 (previs&atilde;o de sa&iacute;da 07:35h e chegada 08:25h) e Volta 08/12/13 (previs&atilde;o de sa&iacute;da 09:05h e chegada 11:50h).</p><p><strong>Op&ccedil;&atilde;o 2: </strong>Ida 07/02/14 (previs&atilde;o de sa&iacute;da 07:35h e chegada 08:25h)&nbsp; e Volta 10/02/14 (previs&atilde;o de sa&iacute;da 15h e chegada 17:55h).</p><p><strong>Op&ccedil;&atilde;o 3: </strong>Ida 14/02/14 (previs&atilde;o de sa&iacute;da 07:35h e chegada 08:25h)&nbsp; e Volta 17/02/14 (previs&atilde;o de sa&iacute;da 15h e chegada 17:55h).</p><p>&nbsp;</p><p><span style="text-decoration: underline;"><strong>Sa&iacute;da S&atilde;o Paulo de R$1596 por R$798 (Alta Temporada)</strong></span></p><p><strong>Op&ccedil;&atilde;o 1:</strong> Ida 10/01/14 (previs&atilde;o de sa&iacute;da 07:35h e chegada 08:25h)&nbsp; e Volta 13/01/14 (previs&atilde;o de sa&iacute;da 15h e chegada 17:55h).</p><p>&nbsp;</p><p><span style="text-decoration: underline;"><strong>Sa&iacute;da Rio de Janeiro de R$1196 por R$598</strong></span></p><p><strong>Op&ccedil;&atilde;o 1: </strong>Ida 14/03/14 (previs&atilde;o de sa&iacute;da 10h e chegada 13:45h)&nbsp; e Volta 17/03/14 (previs&atilde;o de sa&iacute;da 14:15h e chegada 20:11h).</p><p><strong>Op&ccedil;&atilde;o 2: </strong>Ida 21/03/14 (previs&atilde;o de sa&iacute;da 10h e chegada 13:45h)&nbsp; e Volta 24/03/14 (previs&atilde;o de sa&iacute;da 14:15h e chegada 20:11h).</p><p>&nbsp;</p><ul><li>&nbsp;Ao clicar em &ldquo;Comprar&rdquo; escolha a cidade de embarque e o per&iacute;odo da sua viagem.</li></ul><ul><li>O pacote inclui: Passagens a&eacute;reas para Campo Grande saindo de S&atilde;o Paulo e Rio de Janeiro <span>+ transfer aeroporto Campo Grande/hotel Bonito/aeroporto Campo Grande + 3 noites de hospedagem no Hotel Bonsai, Hotel Solar do Cerrado, Pousada Para&iacute;so, ou similar + caf&eacute; da manh&atilde; + Passeio &agrave; Gruta do Lago Azul, incluso transfer, guia e ingresso</span>.</li><li>Cia. A&eacute;rea Tam, Gol, Avianca ou Azul, na classe econ&ocirc;mica promocional, podendo ser alterada conforme disponibilidade.</li><li>V&aacute;lido exclusivamente para 1 pessoa, com acomoda&ccedil;&atilde;o em Quarto Duplo. Caso viaje sozinho, &eacute; obrigat&oacute;ria a troca por Quarto Single, mediante o pagamento de taxa extra de R$200, diretamente &agrave; operadora, no momento da reserva.</li><li>N&atilde;o inclui taxas de embarque e emiss&atilde;o (R$150 por pessoa), que dever&atilde;o ser pagas diretamente &agrave; operadora, no momento da reserva.</li><li>Obrigat&oacute;rio Seguro Viagem, que dever&aacute; ser adquirido diretamente com a operadora no valor promocional de R$35 para todo o per&iacute;odo.</li><li>N&atilde;o inclui despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, e outros consumos n&atilde;o citados na oferta.</li><li>Para 1 crian&ccedil;a com at&eacute; 2 anos incompletos, acompanhada de 2 adultos pagantes, ser&aacute; cobrada apenas taxa de R$185. Para crian&ccedil;a com idade a partir de 2 anos, ser&aacute; necess&aacute;ria a aquisi&ccedil;&atilde;o de um novo cupom.</li></ul><p><span style="text-decoration: underline;">Cupom</span></p><ul><li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li><li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li></ul><p><span style="text-decoration: underline;">Reservas</span></p><ul><li>Preencha e envie o formul&aacute;rio de reserva at&eacute; o dia 05/12/13, atrav&eacute;s do site <a href="http://www.tourinn.com.br/?url=compra_coletiva"><strong>http://www.tourinn.com.br/?url=compra_coletiva</strong></a>.</li><li>Formul&aacute;rios enviados ap&oacute;s esta data sofrer&atilde;o altera&ccedil;&otilde;es nos valores e nas condi&ccedil;&otilde;es de reserva.</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva. Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas.</li><li>Os vouchers (documentos) dos servi&ccedil;os contratados ser&atilde;o disponibilizados pela operadora respons&aacute;vel com at&eacute; 48 horas de anteced&ecirc;ncia &agrave; data de embarque. Eles ser&atilde;o enviados por e-mail.</li><li>N&atilde;o h&aacute; direito de remarca&ccedil;&atilde;o em caso de n&atilde;o comparecimento ou perda do v&ocirc;o.</li><li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es entre em contato atrav&eacute;s do e-mail: </strong><a href="mailto:reservas@tourinn.com.br"><strong>reservas@tourinn.com.br</strong></a><strong> ou ligue (11) 3614-9010, (48) 3206-0902, (48) 3206-0894 e (48) 3369-9083, de segunda a sexta, das 9h &agrave;s 17h.</strong></li><li>As taxas e seguro viagem poder&atilde;o ser parcelados em at&eacute; 12x no cart&atilde;o de cr&eacute;dito diretamente com a operadora.</li></ul><p><span style="text-decoration: underline;">Momento do Embarque</span></p><ul><li>Para embarque &eacute; necess&aacute;rio apresentar a carteira de identidade nacional (RG) emitida pela Secretaria de Seguran&ccedil;a P&uacute;blica, original, em bom estado, na cor verde, com no m&aacute;ximo 10 anos de emiss&atilde;o, Carteira Nacional de Habilita&ccedil;&atilde;o (CNH), Carteira Profissional emitida pelos Conselhos, Carteira Profissional original ou Certificado de Reservista. A documenta&ccedil;&atilde;o &eacute; de exclusiva responsabilidade do passageiro.</li></ul><p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p><ul><li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 07 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrado qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento entre em contato com o INNBat&iacute;vel atrav&eacute;s do email <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li><li>Ap&oacute;s os 07 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li><li>Seu cupom &eacute; considerado utilizado no momento da reserva; em caso de cancelamento, n&atilde;o haver&aacute; a devolu&ccedil;&atilde;o do valor pago.</li><li>Ap&oacute;s a emiss&atilde;o do bilhete, altera&ccedil;&otilde;es s&atilde;o vetadas e o cancelamento resultar&aacute; na perda total do cupom.</li></ul>', '<ul><li>Economize at&eacute; R$798 neste pacote completo!</li><li>Passagens a&eacute;reas para Campo Grande, saindo de S&atilde;o Paulo e Rio de Janeiro.</li><li>3 noites em Bonito + caf&eacute; da manh&atilde; nos hot&eacute;is Bonsai, Solar do Cerrado, Para&iacute;so, ou similar.</li><li>O pacote inclui um caf&eacute; da manh&atilde; super completo para voc&ecirc; aproveitar sua estadia com todo o pique.</li><li>Para sua comodidade o transfer aeroporto Campo Grande / Hotel em Bonito / aeroporto Campo Grande j&aacute; est&aacute; incluso no pacote.</li><li>E Mais! Incluso Passeio a Gruta do Lago Azul com transfer, guia e ingresso. Considerada o cart&atilde;o postal da cidade de Bonito a Gruta do Lago Azul &eacute; um passeio contemplativo e hist&oacute;rico que tem in&iacute;cio com uma caminhada de aprox. 300m at&eacute; a entrada da caverna, onde j&aacute; se pode ter uma ideia de sua beleza. Descendo aprox. 200m por uma escadaria cavada na terra, avista-se um lago que encanta pelas &aacute;guas de tom intensamente azuladas e bel&iacute;ssimos espeleotemas de milhares de anos.</li><li>Bonito &eacute; a Capital Brasileira do Ecoturismo, l&aacute; tudo &eacute; preservado e a infraestrutura para receber os turistas &eacute; de primeiro mundo.</li><li>O INNBat&iacute;vel recomenda que voc&ecirc; fa&ccedil;a a flutua&ccedil;&atilde;o no Rio Sucuri, considerado um dos rios de &aacute;guas mais cristalinas no mundo, permite o visitante apreciar a beleza da flora subaqu&aacute;tica e a intera&ccedil;&atilde;o com diversos cardumes de peixes como piraputangas, pacus, corimbas</li><li>Outra dica &eacute; se aventurar no Bote do Rio Formoso, s&atilde;o de 6 Km de percurso, passando por tr&ecirc;s cachoeiras e duas corredeiras com uma parada para banho de aprox. 20 min. Durante o percurso tem-se a oportunidade de contemplar a fauna e flora &agrave;s margens do rio.</li><li>O INNBat&iacute;vel possui Selo Ouro no e-bit, isso significa que no INNBat&iacute;vel voc&ecirc; pode confiar!</li><li>Confira os hot&eacute;is em Bonito:</li></ul><p><a href="http://www.hotelbonsai.com.br/novoSite/" target="_blank">http://www.hotelbonsai.com.br/novoSite/</a></p><p><a href="http://www.solardocerrado.com.br/" target="_blank">http://www.solardocerrado.com.br/</a></p><p><a href="http://www.pousadaparaisoms.com.br/" target="_blank">http://www.pousadaparaisoms.com.br/</a></p><ul><li>&nbsp;Tem alguma d&uacute;vida? Mande um email para <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> que lhe atenderemos prontamente!</li></ul>', 12, '2013-11-21 12:58:00', '2013-11-27 23:59:59', 'original:/assets/uploads/images/offers/cover/original/qj9dkxps6d4wjx7yjcpfsnsd9s4vkozz.jpg,normal:/assets/uploads/images/offers/cover/normal/dyv0zs8ex5bmlpxcpuoi0fa43wiyzfxp.jpg,thumb:/assets/uploads/images/offers/cover/thumb/l52ig38exwdwizdvpgkxb5t0hhdz21eo.jpg,preview:/assets/uploads/images/offers/cover/preview/penqlibjk8kdjouyhz7botuziw8ezpid.jpg', NULL, NULL, NULL, '', 12, 99, '2013-11-27 11:39:28', '2013-11-27 14:17:15');
/*!40000 ALTER TABLE `offers` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offers_additional
CREATE TABLE IF NOT EXISTS `offers_additional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offer_main_id` int(10) unsigned NOT NULL,
  `offer_additional_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `offers_additional_offer_main_id_index` (`offer_main_id`),
  KEY `offers_additional_offer_additional_id_index` (`offer_additional_id`),
  CONSTRAINT `offers_additional_offer_additional_id_foreign` FOREIGN KEY (`offer_additional_id`) REFERENCES `offers_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offers_additional_offer_main_id_foreign` FOREIGN KEY (`offer_main_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offers_additional: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `offers_additional` DISABLE KEYS */;
/*!40000 ALTER TABLE `offers_additional` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offers_geo_categories
CREATE TABLE IF NOT EXISTS `offers_geo_categories` (
  `offer_id` int(10) unsigned NOT NULL,
  `geo_category_id` int(10) unsigned NOT NULL,
  KEY `offers_geo_categories_offer_id_index` (`offer_id`),
  KEY `offers_geo_categories_geo_category_id_index` (`geo_category_id`),
  CONSTRAINT `offers_geo_categories_geo_category_id_foreign` FOREIGN KEY (`geo_category_id`) REFERENCES `geo_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offers_geo_categories_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offers_geo_categories: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `offers_geo_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `offers_geo_categories` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offers_images
CREATE TABLE IF NOT EXISTS `offers_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(10) unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `offers_images_offer_id_index` (`offer_id`),
  CONSTRAINT `offers_images_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offers_images: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `offers_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `offers_images` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offers_options
CREATE TABLE IF NOT EXISTS `offers_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `included` text COLLATE utf8_unicode_ci,
  `price_original` int(11) DEFAULT NULL,
  `price_with_discount` int(11) DEFAULT NULL,
  `min_qty` int(11) DEFAULT NULL,
  `max_qty` int(11) DEFAULT NULL,
  `max_qty_per_buyer` int(11) DEFAULT NULL,
  `percent_off` int(11) DEFAULT NULL,
  `voucher_validity_start` datetime DEFAULT NULL,
  `voucher_validity_end` datetime DEFAULT NULL,
  `rules` text COLLATE utf8_unicode_ci,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `offers_options_offer_id_index` (`offer_id`),
  CONSTRAINT `offers_options_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offers_options: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `offers_options` DISABLE KEYS */;
INSERT INTO `offers_options` (`id`, `offer_id`, `title`, `subtitle`, `included`, `price_original`, `price_with_discount`, `min_qty`, `max_qty`, `max_qty_per_buyer`, `percent_off`, `voucher_validity_start`, `voucher_validity_end`, `rules`, `display_order`) VALUES
	(2, 785, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(3, 792, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(4, 790, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(5, 786, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(6, 786, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(7, 787, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(8, 791, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(9, 783, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(10, 788, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(11, 789, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1),
	(19, 784, NULL, NULL, NULL, 120000, 60000, 1, 10, 10, 50, NULL, NULL, 'RULES', 1);
/*!40000 ALTER TABLE `offers_options` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offers_saveme
CREATE TABLE IF NOT EXISTS `offers_saveme` (
  `offer_id` int(10) unsigned NOT NULL,
  `saveme_id` int(10) unsigned NOT NULL,
  `priority` int(11) DEFAULT NULL,
  KEY `offers_saveme_offer_id_index` (`offer_id`),
  KEY `offers_saveme_saveme_id_index` (`saveme_id`),
  CONSTRAINT `offers_saveme_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offers_saveme_saveme_id_foreign` FOREIGN KEY (`saveme_id`) REFERENCES `saveme` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offers_saveme: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `offers_saveme` DISABLE KEYS */;
/*!40000 ALTER TABLE `offers_saveme` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.offer_category
CREATE TABLE IF NOT EXISTS `offer_category` (
  `offer_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  KEY `offer_category_offer_id_index` (`offer_id`),
  KEY `offer_category_category_id_index` (`category_id`),
  CONSTRAINT `offer_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offer_category_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.offer_category: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `offer_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer_category` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `braspag_order_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `antifraud_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `braspag_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coupon_id` int(10) unsigned DEFAULT NULL,
  `status` enum('iniciado','aprovado','revisao','rejeitado','pendente','nao_finalizado','abortado','estornado','cancelado','pago','nao_pago') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'iniciado',
  `donation` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `credit_discount` int(11) DEFAULT NULL,
  `cpf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_gift` tinyint(1) NOT NULL DEFAULT '0',
  `payment_terms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boleto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capture_date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `history` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `orders_user_id_index` (`user_id`),
  KEY `orders_coupon_id_index` (`coupon_id`),
  CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `discount_coupons` (`id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.orders: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.orders_offers_options
CREATE TABLE IF NOT EXISTS `orders_offers_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `offer_option_id` int(10) unsigned NOT NULL,
  `qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_offers_options_order_id_index` (`order_id`),
  KEY `orders_offers_options_offer_option_id_index` (`offer_option_id`),
  CONSTRAINT `orders_offers_options_offer_option_id_foreign` FOREIGN KEY (`offer_option_id`) REFERENCES `offers_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_offers_options_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.orders_offers_options: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `orders_offers_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_offers_options` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.partners_testimonies
CREATE TABLE IF NOT EXISTS `partners_testimonies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `destiny` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sponsor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `testimony` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partners_testimonies_partner_id_index` (`partner_id`),
  CONSTRAINT `partners_testimonies_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.partners_testimonies: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `partners_testimonies` DISABLE KEYS */;
/*!40000 ALTER TABLE `partners_testimonies` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.password_reminders
CREATE TABLE IF NOT EXISTS `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.password_reminders: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reminders` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.permissions: ~14 rows (aproximadamente)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'Acessar a página geral de administração.', '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(2, 'admin.user', 'Acessar a página geral de administração de usuários.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(3, 'admin.user.view', 'Visualizar o perfil de um usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(4, 'admin.user.create', 'Criar um usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(5, 'admin.user.edit', 'Editar um usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(6, 'admin.user.delete', 'Excluir um usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(7, 'admin.role', 'Acessar a página geral de administração de papéis de usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(8, 'admin.role.create', 'Criar um papéis de usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(9, 'admin.role.edit', 'Editar um papéis de usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(10, 'admin.role.delete', 'Excluir um papéis de usuário.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(11, 'admin.perm', 'Acessar a página geral de administração de permissões.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(12, 'admin.perm.create', 'Criar uma permissão.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(13, 'admin.perm.edit', 'Editar uma permissão.', '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(14, 'admin.perm.delete', 'Excluir uma permissão.', '2013-11-27 11:39:28', '2013-11-27 11:39:28');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.permission_role
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.permission_role: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.pre_bookings
CREATE TABLE IF NOT EXISTS `pre_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `pre_bookings_offer_id_index` (`offer_id`),
  KEY `pre_bookings_user_id_index` (`user_id`),
  CONSTRAINT `pre_bookings_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pre_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.pre_bookings: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `pre_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `pre_bookings` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_purchasses` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `neighborhood` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_user_id_index` (`user_id`),
  KEY `profiles_city_index` (`city`),
  KEY `profiles_state_index` (`state`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.profiles: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` (`id`, `user_id`, `facebook_id`, `name`, `img`, `total_purchasses`, `credit`, `city`, `state`, `country`, `telephone`, `cpf`, `birth`, `street`, `number`, `zip`, `complement`, `neighborhood`, `ip`) VALUES
	(1, 1, NULL, 'Cawe Coy Rodrigues Marega', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.roles: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `description`, `level`, `created_at`, `updated_at`) VALUES
	(1, 'programador', 'Programador', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(2, 'administrador', 'Administrador', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(3, 'gerente', 'Gerente', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(4, 'Marketing', 'marketing', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(5, 'comercial', 'Comercial', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(6, 'atendimento', 'Atendimento', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(7, 'jornalista', 'Jornalista', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(8, 'designer', 'Designer', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(9, 'parceiro', 'Parceiro', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(10, 'cliente', 'Cliente', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(11, 'visitante', 'Visitante', 777, '2013-11-27 11:39:27', '2013-11-27 11:39:27');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.role_user
CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.role_user: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 2, '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(1, 1, '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(2, 2, '2013-11-27 11:39:28', '2013-11-27 11:39:28'),
	(2, 1, '2013-11-27 11:39:28', '2013-11-27 11:39:28');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.saveme
CREATE TABLE IF NOT EXISTS `saveme` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `geocode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.saveme: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `saveme` DISABLE KEYS */;
/*!40000 ALTER TABLE `saveme` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.states
CREATE TABLE IF NOT EXISTS `states` (
  `id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `states_id_unique` (`id`),
  UNIQUE KEY `states_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.states: ~27 rows (aproximadamente)
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` (`id`, `name`) VALUES
	('AC', 'Acre'),
	('AL', 'Alagoas'),
	('AP', 'Amapá'),
	('AM', 'Amazonas'),
	('BA', 'Bahia'),
	('CE', 'Ceará'),
	('DF', 'Distrito Federal'),
	('ES', 'Espírito Santo'),
	('GO', 'Goiás'),
	('MA', 'Maranhão'),
	('MT', 'Mato Grosso'),
	('MS', 'Mato Grosso do Sul'),
	('MG', 'Minas Gerais'),
	('PA', 'Pará'),
	('PB', 'Paraíba'),
	('PR', 'Paraná'),
	('PE', 'Pernambuco'),
	('PI', 'Piauí'),
	('RJ', 'Rio de Janeiro'),
	('RN', 'Rio Grande do Norte'),
	('RS', 'Rio Grande do Sul'),
	('RO', 'Rondônia'),
	('RR', 'Roraima'),
	('SC', 'Santa Catarina'),
	('SP', 'São Paulo'),
	('SE', 'Sergipe'),
	('TO', 'Tocantins');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.suggest_a_trip
CREATE TABLE IF NOT EXISTS `suggest_a_trip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `destiny` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suggestion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.suggest_a_trip: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `suggest_a_trip` DISABLE KEYS */;
/*!40000 ALTER TABLE `suggest_a_trip` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.tell_us
CREATE TABLE IF NOT EXISTS `tell_us` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `destiny` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `partner_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `travel_date` datetime DEFAULT NULL,
  `depoiment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.tell_us: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tell_us` DISABLE KEYS */;
/*!40000 ALTER TABLE `tell_us` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '1',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_password_index` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.users: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `verified`, `disabled`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'felipepodesta', '$2y$08$2gc3tpEZ2Z1ez8yUR00T3OWjJJAjUXiaY/K6zr.Yb4NNX.3oEfhxq', '23779a22466bae4d83aa638cf4664b0e', 'felipepodesta@me.com', 1, 0, NULL, '2013-11-27 11:39:27', '2013-11-27 11:39:27'),
	(2, 'cawecoy', '$2y$08$jiPUXgnGQ0nwK9rw2U.vwe9lmc48TjCHavKv6ZgsdBmGPKnDvMpmC', '7973ef5308ec3ab30a91fb845424739c', 'cawecoy@gmail.com', 1, 0, NULL, '2013-11-27 11:39:27', '2013-11-27 11:39:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.users_credits
CREATE TABLE IF NOT EXISTS `users_credits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `new_user_id` int(10) unsigned NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_credits_user_id_index` (`user_id`),
  KEY `users_credits_new_user_id_index` (`new_user_id`),
  KEY `users_credits_value_index` (`value`),
  CONSTRAINT `users_credits_new_user_id_foreign` FOREIGN KEY (`new_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_credits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.users_credits: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users_credits` DISABLE KEYS */;
INSERT INTO `users_credits` (`id`, `user_id`, `new_user_id`, `value`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, '3000', '2013-11-27 11:39:28', '2013-11-27 11:39:28');
/*!40000 ALTER TABLE `users_credits` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.users_indications
CREATE TABLE IF NOT EXISTS `users_indications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `users_indications_user_id_index` (`user_id`),
  KEY `users_indications_email_index` (`email`),
  CONSTRAINT `users_indications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.users_indications: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users_indications` DISABLE KEYS */;
INSERT INTO `users_indications` (`id`, `user_id`, `name`, `email`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Almerir de Silveirado Jacaré', 'jacare@gmail.com', '2013-11-27 11:39:28', '2013-11-27 11:39:28');
/*!40000 ALTER TABLE `users_indications` ENABLE KEYS */;


-- Copiando estrutura para tabela innbativel.vouchers
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_offer_id` int(10) unsigned NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `display_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vouchers_order_offer_id_index` (`order_offer_id`),
  CONSTRAINT `vouchers_order_offer_id_foreign` FOREIGN KEY (`order_offer_id`) REFERENCES `orders_offers_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela innbativel.vouchers: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
