## Laravel Todo API

This package has developed to extend laravel functionality with todo tasks

## Getting Started

PHP Version: 7.4+

Laravel Version: 7.x

Composer

## Installation

Run require command with composer:

`composer require psli/todo`

Publish migrations:

`php artisan vendor:publish --provider="Psli\Todo\TodoPackageServiceProvider" --tag="migrations"`

`php artisan migrate`


Use trait `HasTasks` in your User model
## Usage


There are 2 models related to each:

1. Label: Labels help users to filter tasks. labels should be unique and system should not have a duplicate label.
2. Task: Task contains Title, Description, and Status.


The relations are as following:


1. User can have 1 + n task.
2. Task can have 1 + n label.

After install you can use php artisan route:lists and find new routes added to your laravel.



I assume have a column name "token" in our User model and auth users with custom middleware in the package.


## Test


`composer test`

## License

Distributed under the MIT License. See `LICENSE.md` for more information.


## Contact

Pouya Salimi - [@pouya](https://twitter.com/pouya) - pouya@salimi.info

Project Link: [https://github.com/pouyasalimi/laravel_todo](https://github.com/pouyasalimi/laravel_todo)

<p align="right">(<a href="#top">back to top</a>)</p>
