<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace tool_adminassist\local;

/**
 * Builds the first Admin Assist dashboard model from existing Moodle admin surfaces.
 *
 * @package    tool_adminassist
 * @copyright  2026 eLeDia GmbH
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class dashboard_provider {
    /**
     * Return grouped dashboard sections.
     *
     * @return array<int, array<string, mixed>>
     */
    public function get_sections(): array {
        return [
            [
                'id' => 'operations',
                'title' => get_string('section_operations', 'tool_adminassist'),
                'description' => get_string('section_operations_desc', 'tool_adminassist'),
                'items' => [
                    $this->cron_item(),
                    $this->link_item(
                        'adminnotifications',
                        'adminnotifications_desc',
                        '/admin/index.php',
                        'status_neutral',
                        'badge-info'
                    ),
                    $this->link_item(
                        'scheduledtasks',
                        'scheduledtasks_desc',
                        '/admin/tool/task/scheduledtasks.php',
                        'status_neutral',
                        'badge-info'
                    ),
                ],
            ],
            [
                'id' => 'quality',
                'title' => get_string('section_quality', 'tool_adminassist'),
                'description' => get_string('section_quality_desc', 'tool_adminassist'),
                'items' => [
                    $this->debugging_item(),
                    $this->link_item(
                        'environment',
                        'environment_desc',
                        '/admin/environment.php',
                        'status_neutral',
                        'badge-info'
                    ),
                    $this->link_item(
                        'plugins',
                        'plugins_desc',
                        '/admin/plugins.php',
                        'status_neutral',
                        'badge-info'
                    ),
                ],
            ],
            [
                'id' => 'security',
                'title' => get_string('section_security', 'tool_adminassist'),
                'description' => get_string('section_security_desc', 'tool_adminassist'),
                'items' => [
                    $this->link_item(
                        'securitychecks',
                        'securitychecks_desc',
                        '/report/security/index.php',
                        'status_neutral',
                        'badge-info'
                    ),
                    $this->link_item(
                        'passwordpolicy',
                        'passwordpolicy_desc',
                        '/admin/settings.php?section=sitepolicies',
                        'status_neutral',
                        'badge-info'
                    ),
                    $this->link_item(
                        'scheduledbackup',
                        'scheduledbackup_desc',
                        '/admin/settings.php?section=automated',
                        'status_neutral',
                        'badge-info'
                    ),
                ],
            ],
        ];
    }

    /**
     * Build a cron status item.
     *
     * @return array<string, string>
     */
    private function cron_item(): array {
        $lastcron = (int)get_config('core', 'lastcron');
        if ($lastcron <= 0) {
            return $this->link_item('cron', 'cron_never_desc', '/admin/cron.php', 'status_warning', 'badge-warning');
        }

        $age = time() - $lastcron;
        if ($age > HOURSECS) {
            return $this->link_item('cron', 'cron_late_desc', '/admin/cron.php', 'status_warning', 'badge-warning');
        }

        return $this->link_item('cron', 'cron_ok_desc', '/admin/cron.php', 'status_ok', 'badge-success');
    }

    /**
     * Build a debugging status item.
     *
     * @return array<string, string>
     */
    private function debugging_item(): array {
        global $CFG;

        if (!empty($CFG->debug) && $CFG->debug !== DEBUG_NONE) {
            return $this->link_item(
                'debugging',
                'debugging_enabled_desc',
                '/admin/settings.php?section=debugging',
                'status_warning',
                'badge-warning'
            );
        }

        return $this->link_item(
            'debugging',
            'debugging_ok_desc',
            '/admin/settings.php?section=debugging',
            'status_ok',
            'badge-success'
        );
    }

    /**
     * Build a generic linked dashboard item.
     *
     * @param string $titlekey title language key
     * @param string $descriptionkey description language key
     * @param string $url Moodle-relative URL
     * @param string $statuskey status language key
     * @param string $badgeclass Bootstrap badge class
     * @return array<string, string>
     */
    private function link_item(
        string $titlekey,
        string $descriptionkey,
        string $url,
        string $statuskey,
        string $badgeclass
    ): array {
        return [
            'title' => get_string($titlekey, 'tool_adminassist'),
            'description' => get_string($descriptionkey, 'tool_adminassist'),
            'url' => (new \moodle_url($url))->out(false),
            'status' => get_string($statuskey, 'tool_adminassist'),
            'badgeclass' => $badgeclass,
        ];
    }
}
