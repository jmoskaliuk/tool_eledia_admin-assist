# Admin Assist

Admin Assist is a Moodle admin tool (`tool_adminassist`) that gives site administrators a compact overview of important operational todos and direct links into existing Moodle administration pages.

## Current MVP

- Central admin page in the Moodle site administration tree as `Admin Assist`
- Operational checks for cron and debugging state
- Shortcuts to notifications, scheduled tasks, environment checks, plugins, security report, site policies and automated backups
- Privacy API implementation declaring that the plugin stores no personal data
- Basic PHPUnit coverage for the dashboard provider
- GitHub Actions workflow using `moodle-plugin-ci`

## Installation

Install this repository as:

```text
admin/tool/adminassist
```

Then run the Moodle upgrade.

## Development

The plugin follows the project DevFlow in `docs/devflow/` and the shared eLeDia OS DevFlow repository.

Run local checks from a Moodle checkout with `moodle-plugin-ci` available:

```bash
moodle-plugin-ci phplint
moodle-plugin-ci phpcs --max-warnings 0
moodle-plugin-ci phpdoc --max-warnings 0
moodle-plugin-ci validate
moodle-plugin-ci phpunit
```
