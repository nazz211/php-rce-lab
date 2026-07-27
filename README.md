# Comparative Security Assessment of PHP Remote Code Execution (RCE) via File Upload in PM2 and Docker Deployment Environments

WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.

This project is a lightweight educational lab that demonstrates an unrestricted file-upload vulnerability in a plain PHP application. The same source code is deployed in two independent environments:

1. PM2-managed PHP development server
2. Docker-based Apache/PHP container

The purpose is to compare how deployment architecture changes the impact of an application-level unrestricted file-upload vulnerability.

## 1. Project architecture

The repository is organized as follows:

- app/ – the vulnerable PHP application
- app/uploads/ – web-accessible upload directory
- docs/ – comparison notes and testing methodology
- docker/ – Docker build context
- ecosystem.config.cjs – PM2 process definition
- docker-compose.yml – Docker Compose deployment
- .dockerignore – Docker build exclusions

## 2. Vulnerability explanation

The upload feature intentionally accepts arbitrary files and stores them under the web-accessible uploads directory without allowlisting, MIME validation, or content inspection. That means a PHP file can be uploaded and then executed by requesting it through the web server.

This is an intentionally insecure lab implementation. The code contains source comments marking the insecure behavior.

## 3. PM2 architecture

PM2 supervises a PHP built-in development server that serves the app from the app/ directory on localhost port 8000. The process is configured for automatic restart and logging.

## 4. Docker architecture

Docker uses an Apache/PHP container. The application directory is copied into the container, and the upload directory is exposed as a bind mount so uploads can be inspected on the host as well as inside the container.

## 5. Installation

### Prerequisites

- PHP installed locally
- PM2 installed locally
- Docker and Docker Compose installed if you want to run the containerized version

### Local setup

```bash
cd php-rce-deployment-lab
mkdir -p logs
```

## 6. Deployment

### PM2 deployment

```bash
cd php-rce-deployment-lab
pm2 start ecosystem.config.cjs
```

#### PM2 commands

```bash
pm2 start ecosystem.config.cjs
pm2 stop php-rce-lab
pm2 restart php-rce-lab
pm2 status
pm2 logs php-rce-lab
pm2 save
pm2 startup
```

The app will be reachable at:

```text
http://127.0.0.1:8000/
```

### Docker deployment

```bash
cd php-rce-deployment-lab
docker compose up --build -d
```

The app will be reachable at:

```text
http://127.0.0.1:8080/
```

## 7. Safe testing methodology

Use the lab credentials:

- Username: lab
- Password: labpass

Upload a harmless PHP proof-of-concept such as:

```php
<?php
echo "Lab RCE proof-of-concept\n";
echo "PHP version: " . PHP_VERSION . "\n";
echo "Current user: " . get_current_user() . "\n";
echo "Working directory: " . getcwd() . "\n";
?>
```

Verify that:

- PHP uploads are accepted
- uploaded PHP files are web accessible
- uploaded PHP code executes
- execution identity can be observed
- working directory can be observed
- application-directory access can be compared

Do not use a full-featured web shell.

## 8. Evidence and screenshots checklist

Capture evidence for the lab report:

- screenshot of the login screen
- screenshot of the upload form
- screenshot of a successful upload message
- screenshot of the uploaded file being opened in the browser
- screenshot of the status page showing the execution context
- screenshot of the files listing page

## 9. PM2 vs Docker observations

PM2 runs the PHP application as a host-managed process with a simple localhost binding. Docker runs the application inside an Apache/PHP container with container-based isolation. The vulnerable code remains the same in both cases, but the security boundary and execution context differ.

## 10. Security findings

The application contains a critical upload issue because it stores arbitrary files under the web root without validation. In both PM2 and Docker, an attacker who can upload a PHP file could cause code execution if the app is reachable.

## 11. Mitigation recommendations

In a real application, the upload flow should be fixed by:

- allowlisting permitted extensions
- validating MIME types
- inspecting file content or using image libraries where appropriate
- storing uploads outside the web root
- using a non-executable storage directory
- enforcing authentication and authorization on upload actions
- removing the vulnerable code path entirely

## 12. Cleanup instructions

```bash
rm -f app/uploads/*
pm2 stop php-rce-lab
# or, for Docker
cd php-rce-deployment-lab
docker compose down
```

## Notes

This lab should stay confined to localhost or an isolated test network. The application should never be exposed to the public internet.
