# PM2 vs Docker Security Comparison

| Category | PM2 | Docker |
| --- | --- | --- |
| Code execution context | PHP built-in server runs the application directly from the project directory. | Apache/PHP runs the application inside a container process. |
| Effective user | Usually the current host user or the PHP server process owner. | Usually the container's www-data user unless explicitly changed. |
| Process isolation | Limited; the app runs as a host process and shares the host filesystem. | Stronger boundary by default; the app is isolated inside the container namespace. |
| Filesystem exposure | The app's files and uploads are directly exposed on the host filesystem. | The app's files are inside the container image and bind-mounted upload directory. |
| Host exposure | A localhost bind to 127.0.0.1 is safer than binding to all interfaces. | The container port can be bound to localhost for a lab deployment. |
| Writable directories | The uploads directory is writable by the runtime and accessible through the web server. | The upload directory may be bind-mounted to the host, making persistence easy to observe. |
| Network exposure | The application is reachable on the configured localhost port. | The container port is mapped to a host port, usually localhost for safety. |
| Persistence | PM2 can keep the process alive across restarts and can retain logs. | Docker can restart containers automatically and preserve bind-mounted uploads. |
| Logging | PM2 stores stdout/stderr logs. | Docker logs and container logs can capture application output. |
| Recovery | Restarting PM2 is simple. | Restarting the container is simple, but there may be extra orchestration layers. |
| Security boundary | Thin; a compromise affects the host process environment. | Better isolation, but the vulnerable PHP code remains vulnerable inside the container. |

Docker does not fix the vulnerable PHP upload implementation. Instead, properly configured container isolation can reduce the scope and impact of compromise by containing the application process in a separate runtime boundary.
