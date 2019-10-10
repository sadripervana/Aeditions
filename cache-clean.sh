#!/bin/bash
compile=false
deploy=false
backup=false
template_hints_enable=false
template_hints_disable=false
clean_cache=true

for var in "$@"
do
	if [[ $var == 'b' ]]; then
		backup=true
		clean_cache=false
	fi
	if [[ $var == 'c' ]]; then
		compile=true
		clean_cache=true
	fi
	if [[ $var == 'd' ]]; then
		deploy=true
		clean_cache=true
	fi
	if [[ $var == 'st' ]]; then
		template_hints_enable=true
		clean_cache=true
	fi
	if [[ $var == 'ut' ]]; then
		template_hints_disable=true
		clean_cache=true
	fi
done
# Backup
if [[ $backup == true ]]; then
	sudo chmod -R 777 var generated pub/static
	sudo rm -rf pub/static/_cache/ pub/static/frontend/ pub/static/adminhtml/
	echo "Removed pub static files"
	sudo chmod -R 777 var generated pub/static
	sudo rm -rf var/view_preprocessed/pub/static/
	echo "Removed view preprocessed files"
	php bin/magento maintenance:enable
	mkdir -p "backup"

	cat <<EOF >backup/.gitignore
*
*/
!.gitignore
EOF

	host=`php -r '$data = include("app/etc/env.php"); echo $data["db"]["connection"]["default"]["host"];'`
	database=`php -r '$data = include("app/etc/env.php"); echo $data["db"]["connection"]["default"]["dbname"];'`
	username=`php -r '$data = include("app/etc/env.php"); echo $data["db"]["connection"]["default"]["username"];'`
	password=`php -r '$data = include("app/etc/env.php"); echo $data["db"]["connection"]["default"]["password"];'`
	# read -p 'Database: ' database
	# read -p 'User: ' user
	# read -sp 'User: ' password
	mysqldump -u $username -p"$password" -h $host $database > "backup/"$database".sql" &>/dev/null
	zipPath="backup/backup_"$(date "+%Y.%m.%d-%H.%M")".zip"
	zip	-r $zipPath . "vendor/.htaccess" -x "backup/*.zip" "vendor/*/*" "vendor/autoload.php" ".git/*" &>/dev/null
	rm -rf "backup/"$database".sql"
	echo "Bakcup created" $zipPath
	php bin/magento maintenance:disable
	echo "Deployed static content"
fi
# Deploy
if [[ $compile == true ]]; then
	sudo chmod -R 777 var generated pub/static
	php bin/magento setup:upgrade
	php bin/magento setup:di:compile
fi
# Compile
if [[ $deploy == true ]]; then
	sudo chmod -R 777 var generated pub/static
	sudo rm -rf pub/static/_cache/ pub/static/frontend/ pub/static/adminhtml/
	echo "Removed pub static files"
	sudo chmod -R 777 var generated pub/static
	sudo rm -rf var/view_preprocessed/pub/static/
	echo "Removed view preprocessed files"
	php bin/magento setup:static-content:deploy it_IT -f -a frontend
#	php bin/magento setup:static-content:deploy en_US -f
	echo "Deployed static content"
fi

# set template hints
if [[ $template_hints_enable == true ]]; then
	php bin/magento dev:template-hints:enable
fi

# unset template hints
if [[ $template_hints_disable == true ]]; then
	php bin/magento dev:template-hints:disable
fi

# Clean cache
if [[ $clean_cache == true ]]; then
	sudo chmod -R 777 var generated pub/static
	php bin/magento cache:clean
	sudo chmod -R 777 var generated pub/static
	php bin/magento cache:flush
	sudo chmod -R 777 var generated pub/static
fi
