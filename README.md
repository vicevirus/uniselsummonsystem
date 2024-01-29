# UNISEL Summon System

The UNISEL Summon System is a comprehensive solution designed for Universiti Selangor (UNISEL) to manage and process summons efficiently. This system is built using Laravel for the backend and frontend, while it uses Flutter for mobile app scanning, providing a robust and user-friendly experience.

## Features

- **Summon Issuance:** Allows authorized personnel to issue summons.
- **Payment Processing:** Facilitates the payment of summons online.
- **User Management:** Manages user accounts, including students and staff.
- **Reporting:** Generates reports on summons issued, paid, and outstanding.
- **Notification System:** Sends alerts and reminders to users.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP >= 7.3
- Composer
- Flutter SDK
- MySQL or any SQL database system

### Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/unisel-summon-system.git
   ```

2. **Set Up the Backend**

   Navigate to the backend folder and install dependencies:

   ```bash
   cd backend
   composer install
   ```

   Set up your `.env` file with your database credentials and run migrations:

   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```

3. **Set Up the Frontend**

   Navigate to the frontend folder and install dependencies:

   ```bash
   cd ../frontend
   flutter pub get
   ```

   Run the Flutter application:

   ```bash
   flutter run
   ```

<!-- ## Usage

Provide instructions on how to use the system. -->

<!-- ## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us. -->

<!-- ## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your-username/unisel-summon-system/tags). -->

<!-- ## Authors

- **Your Name** - *Initial work* - [YourUsername](https://github.com/YourUsername)

See also the list of [contributors](https://github.com/your-username/unisel-summon-system/contributors) who participated in this project. -->

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

- Hat tip to anyone whose code was used
- Inspiration
- etc

