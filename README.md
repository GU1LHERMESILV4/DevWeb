# Shrek's Swamp - Character Database

A fun and interactive web application for managing Shrek characters, built with PHP, HTML, and CSS.

## Features

- Create, Read, Update, and Delete (CRUD) operations for Shrek characters
- Responsive design with a Shrek-themed interface
- Modal-based editing system
- Image support for character cards

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. Clone this repository to your web server directory
2. Create a MySQL database named `shrek_db`
3. Create the characters table using the following SQL:

```sql
CREATE TABLE characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Update the database credentials in `config.php` if needed
5. Access the application through your web browser

## Usage

1. Add new characters using the form at the top of the page
2. View all characters in the grid below
3. Edit or delete characters using the buttons on each character card
4. Images should be provided as URLs (you can use image hosting services)

## Security Features

- Input sanitization
- Prepared statements for database queries
- XSS prevention through proper escaping

## Contributing

Feel free to submit issues and enhancement requests! 