#!/bin/sh
# /usr/local/bin
#echo $1
#php -q /var/www/clients/includes/hooks/exorder1.php $1


mysqldump --add-drop-table -ujreiter -pbltr3df94pz12 -h69.61.88.13 500_freepbx > /var/www/clients/templates_c/500_freepbx
mysqldump --add-drop-table -ujreiter -pbltr3df94pz12 -h69.61.88.13 500_asteriskcdrdb > /var/www/clients/templates_c/500_asteriskcdrdb
mysqldump --add-drop-table -ujreiter -pbltr3df94pz12 -h69.61.88.13 500_fop2 > /var/www/clients/templates_c/500_fop2

mysqladmin -ujreiter -pbltr3df94pz12 -h69.61.88.13 -f DROP DATABASE IF EXISTS `$1_freepbx`
mysqladmin -ujreiter -pbltr3df94pz12 -h69.61.88.13 -f DROP DATABASE IF EXISTS `$1_asteriskcdrdb`
mysqladmin -ujreiter -pbltr3df94pz12 -h69.61.88.13 -f DROP DATABASE IF EXISTS `$1_fop2` 

mysqladmin -ujreiter -pbltr3df94pz12 -h69.61.88.13 -f CREATE `$1_freepbx`
mysqladmin -ujreiter -pbltr3df94pz12 -h69.61.88.13 -f CREATE `$1_asteriskcdrdb`
mysqladmin -ujreiter -pbltr3df94pz12 -h69.61.88.13 -f CREATE `$1_fop2`


mysql -ujreiter -pbltr3df94pz12 -h69.61.88.13 `$1_freepbx` < /var/www/clients/templates_c/500_freepbx
mysql -ujreiter -pbltr3df94pz12 -h69.61.88.13 `$1_asteriskcdrdb` < /var/www/clients/templates_c/500_asteriskcdrdb
mysql -ujreiter -pbltr3df94pz12 -h69.61.88.13 `$1_fop2` < /var/www/clients/templates_c/500_fop2


exit 1
