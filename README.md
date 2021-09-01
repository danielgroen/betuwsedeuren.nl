## Werkenbij

## Requirements
- [Direnv](https://direnv.net/docs/installation.html): follow the instructions online to install.
  - For Bash users: place `eval "$(direnv hook bash)"` in ~/.bashrc
  - For Zsh users: place `eval "$(direnv hook zsh)"` in ~/.zshrc

## Installation
1. Setup local environment by copying the file `./docker/.env.example` to `./docker/.env` and change the config if you want
2. run the command `$ up -d` (-d is for deamon mode)
4. Run the command `$ composer i` to install vendor packages for Wordpress
4. Run the installation of Wordpress in the browser and Log in
5. go to settings -> permalinks and save this page
6. set the theme to the 'jacket theme'
7. Activate all the plugins

## Commands
- `$backup` # create a db backup
- `$down` # stop the containers of the project
- `$purge` # remove all data from the project (also deletes the db)
- `$restart` # restart the containers
- `$restore` # import a db backup
- `$shell` # enter a container, use parameters to define which container
- `$up` # builds and start the project

## development
- run `$ npm start` in order to compile scss files
