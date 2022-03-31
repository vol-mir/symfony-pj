#!/bin/bash
# Deploy script

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cat <<-HELP
Deploying process will:
1. Remove all vendor data from directory:
    ${SCRIPT_DIR}/vendor
2. Setup PHP vendor dependencies
3. Remove all cache from directory:
    ${SCRIPT_DIR}/data/cache
4. Apply all DB migrations
5. Install Node vendor dependencies

HELP

while true; do
    read -p "Are you sure you want to deploy(y/n)? " ANSWER
    case $ANSWER in
        [Yy]* )
            printf "Start deploying...\n"
            cd ${SCRIPT_DIR}

            cp .env.example .env

            # Install PHP vendor dependencies
            rm -rf vendor
            composer install

            # Apply migrations
            rm -r migrations/*
            mkdir migrations
            php bin/console doctrine:database:create --if-not-exists
            php bin/console doctrine:schema:drop --force --full-database
            php bin/console doctrine:migration:diff
            php bin/console doctrine:migration:migrate --no-interaction

            # Install nodejs, npm, yarn and node version switcher "n"
            apt-get update
            apt-get install -y nodejs npm
            npm cache clean --force
            npm install -g yarn
            npm install n -g

            yarn add --dev @symfony/webpack-encore
            yarn add webpack-notifier --dev
            yarn encore dev
            yarn add @babel/preset-react --dev
            yarn add react-router-dom
            yarn add --dev react react-dom prop-types axios
            yarn add @babel/plugin-proposal-class-properties @babel/plugin-transform-runtime

            sudo chmod -R 0777 data
            
        exit;;
        [Nn]* )
            printf "\nExit with no changes\n"
        exit;;
        * ) printf "Please answer yes or no.\n\n";;
    esac
done
