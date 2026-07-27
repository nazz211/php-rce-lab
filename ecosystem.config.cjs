module.exports = {
  apps: [
    {
      name: 'php-rce-lab',
      script: './scripts/start-php.sh',
      cwd: __dirname,
      autorestart: true,
      watch: false,
      env: {
        NODE_ENV: 'development',
        LAB_WARNING: 'WARNING: Intentionally Vulnerable Cybersecurity Lab. Run only on localhost or an isolated test network. Never expose this application to the public internet.'
      },
      error_file: './logs/pm2-error.log',
      out_file: './logs/pm2-out.log',
      log_date_format: 'YYYY-MM-DD HH:mm:ss'
    }
  ]
};
