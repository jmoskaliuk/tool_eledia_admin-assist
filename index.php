<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Admin Assist overview page.
 *
 * @package    tool_adminassist
 * @copyright  2026 eLeDia GmbH
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('tool_adminassist');

$context = \core\context\system::instance();
require_capability('tool/adminassist:view', $context);

$provider = new \tool_adminassist\local\dashboard_provider();
$templatecontext = [
    'intro' => get_string('overviewintro', 'tool_adminassist'),
    'sections' => $provider->get_sections(),
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('tool_adminassist/dashboard', $templatecontext);
echo $OUTPUT->footer();
