# Safe Testing Methodology

This document describes a safe lab verification path for demonstrating the upload vulnerability without turning the exercise into a real attack.

## Step 1: Log in

Use the hardcoded lab credentials:

- Username: lab
- Password: labpass

## Step 2: Upload a harmless PHP proof of concept

Create a simple PHP file that emits fixed text and runtime details:

```php
<?php
echo "Lab RCE proof-of-concept";
echo "\n";
echo "PHP version: " . PHP_VERSION;
echo "\n";
echo "Current user: " . get_current_user();
echo "\n";
echo "Working directory: " . getcwd();
?>
```

Upload this file through the vulnerable page.

## Step 3: Confirm execution

Open the uploaded file through the web server using the URL shown on the files page.

You should observe:

- the file was accepted
- the file is accessible through the web server
- the embedded PHP code executes
- the effective user and working directory output are visible

## Step 4: Compare the environments

- In PM2, the application runs as a process under the host runtime.
- In Docker, the same PHP code runs inside the container environment.

Use the status page to compare:

- application directory
- upload directory
- execution user
- working directory

## Step 5: Cleanup

Delete the uploaded files and stop the service or container when the lab is complete.
