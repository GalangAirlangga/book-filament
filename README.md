## Book Inventory System
This is a book inventory system that allows users to manage their book collections, keep track of stocks. The system is built using Laravel, a PHP web framework.

### Features
1. Manage book collections: Add, edit, or delete books and their details such as ISBN, title, category, publisher, description, image, etc. 
2. Track book stocks: Keep track of the total number of books in the warehouse, stock for each title, and stock minimum. 
3. Category management: Add, edit, or delete categories, and view the number of books for each category. 
4. Publisher management: Add, edit, or delete publishers, and view the number of books for each publisher.


### Requirements
* PHP 8.0 or higher 
* Laravel 9.19 or higher 
* MySQL 5.7 or higher


### Setup
1. Clone the repository using the command git clone https://github.com/GalangAirlangga/book-filament.git
2. Change into the project directory using the command cd book-filament. 
3. Run composer install to install the required dependencies. 
4. Copy the .env.example file to a new file named .env and fill in your database information. 
5. Run php artisan key:generate to generate a new application key. 
6. Run php artisan migrate --seed to create the database tables. 
7. Start the development server using the command php artisan serve. 
8. Access the application in your browser at http://localhost:8000.

### Contributing
Contributions are welcome. If you have any ideas, please open an issue to discuss them. If you would like to contribute, please fork the repository and make a pull request.

### License
This project is open-source software licensed under the MIT license.
