## Install
* `composer update`
* `npm install`

## Run
* `npm run dev`
* `php artisan migrate`
* `php artisan VueTranslation:generate --watch=1` (to watch for new translations that can be used within Vue, uses https://github.com/tohidplus/laravel-vue-translation)

## Gates
Currently the following gates are available:

* isAdmin
* manageClients
* manageSla
* manageProjects
* manageActivities
* accessTimemanagement
* viewReporting
* isHr
* accessInvoicing