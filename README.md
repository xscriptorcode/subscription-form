**Subscription Form**
This project is a basic PHP form that allows users to subscribe to a blog. The form validates the email input and limits the number of daily subscriptions to prevent spam or accidental overload.

Features
Email Validation: Ensures that only valid email addresses are accepted.
Daily Limit: Limits subscriptions to 100 entries per day, helping manage and monitor daily activity.
Database Integration: Stores subscribers' emails in a MySQL database.

Setup Instructions:


```bash
##Clone repository
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
Database Setup

##Create a MySQL database and table for storing subscribers. You can use the following SQL to set up the NewsletterSubscriber table:

sql
Copiar código
CREATE TABLE NewsletterSubscriber (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Update the database.php configuration file with your database credentials. This file should be located in the root directory and contain:


<?php
return [
    'host' => 'your_database_host',
    'user' => 'your_database_user',
    'pass' => 'your_database_password',
    'name' => 'your_database_name',
];
```

Enable Error Reporting for Development Error reporting is enabled for development purposes in the script. Ensure this is disabled in production.

Upload to Server

Upload the project files to your web server. Make sure your server supports PHP and has access to the MySQL database.
Run the Form

Open the form in a web browser and test it by submitting an email address.
How It Works
The form checks if the email input is received.
It validates the email format.
It checks the database to see if the daily subscription limit (100 entries) has been reached.
If the limit is not exceeded, it saves the email to the database and confirms the subscription.
If the limit is reached or if any errors occur, it returns an error message in JSON format.
Example Responses
Success:

```bash
json
Copiar código
{
    "success": true,
    "message": "Thank you for subscribing!"
}
Invalid Email:

json
Copiar código
{
    "success": false,
    "error": "Invalid email address."
}
Daily Limit Reached:

json
Copiar código
{
    "success": false,
    "error": "The daily limit of 100 registrations has been reached."
}

```

**Important Notes:**

Make sure to secure your database credentials and consider disabling error reporting in production.
Consider additional security measures such as captcha or rate limiting for production environments.

**License**
This project is open-source and available under the MIT License.