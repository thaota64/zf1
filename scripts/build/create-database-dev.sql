
FLUSH PRIVILEGES;
CREATE DATABASE  IF NOT EXISTS `profile_live` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
CREATE DATABASE  IF NOT EXISTS `profile_dev` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
CREATE DATABASE  IF NOT EXISTS `profile_testing` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

CREATE USER 'profile_live'@'127.0.0.1' IDENTIFIED BY 'profile_live';
CREATE USER 'profile_dev'@'127.0.0.1' IDENTIFIED BY 'profile_dev';
CREATE USER 'profile_testing'@'127.0.0.1' IDENTIFIED BY 'profile_testing';

GRANT ALL PRIVILEGES ON profile_live.* TO 'profile_live'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON profile_dev.* TO 'profile_dev'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON profile_testing.* TO 'profile_testing'@'%' WITH GRANT OPTION;



