# Test Project Result

## Live site link

- Visitor Site  
https://test.otlub.com/

- Engineering Team Site  
https://test.otlub.com/dashboard.php

## Loom Video


# Bug Tracker

A simple two-way bug tracking application using pure PHP (no frameworks) and SQLite as the data store.  
This application allows visitors to submit bugs using a widget on public pages.  
The engineering team can view, update the status, and add comments to the bugs. Notifications are provided to the visitors on status changes.  

## Features

- GitHub OAuth for authentication
- Public bug reporting widget
- Real-time updates without page reloads using HTMX
- SQLite database for storing bugs and user data
- Tailwind CSS for styling

## Prerequisites

- PHP >= 7.4
- Composer
- SQLite

## Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/yourusername/bug-tracker.git
   cd bug-tracker
   ```

2. Install dependencies:

   ```sh
   composer install
   ```

3. Create and configure the `.env` file:

   Create a `.env` file in the root of the project and add the following variables:  

   ```env
   CLIENT_ID=your_github_client_id
   CLIENT_SECRET=your_github_client_secret
   APP_URL=app_url
   ```

4. Update the `php.ini` file:
   ```ini
   extension=sqlite3.so
   extension=pdo_sqlite.so
   ```

5. Start your web server (Apache)  

## Project Structure   

```
bug-tracker/
├── .env
├── auth.php
├── bootstrap.php
├── composer.json
├── core/
│   └── find_bug.php
│   └── list_bugs.php
│   └── report_bug.php
│   └── report_bug_form.php
│   └── update_bug.php
│   └── auth/
│   └────── auth.php 
│   └────── callback.php 
│   └── db/
│   └────── sqlite.php 
│   └────── database/
│   └─────────────bugtracker.db 
│   └─────────────schema.sql
```

## Usage

1. Public Page:
   - Visit `https://test.otlub.com/` to access the public page.
   - Click the "Report a Bug" button to submit a bug report.

2. Engineering Dashboard:
   - Visit `https://test.otlub.com/dashboard.php` to authenticate via GitHub and access the dashboard.
   - View, update the status, and add comments to bugs.
