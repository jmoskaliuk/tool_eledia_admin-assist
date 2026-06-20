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
 * Tests for the dashboard provider.
 *
 * @package    tool_adminassist
 * @copyright  2026 eLeDia GmbH
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \tool_adminassist\local\dashboard_provider
 */
final class dashboard_provider_test extends \advanced_testcase {
    /**
     * The dashboard exposes the expected first-level admin groups.
     */
    public function test_get_sections_returns_dashboard_groups(): void {
        $provider = new dashboard_provider();

        $sections = $provider->get_sections();

        $this->assertCount(3, $sections);
        $this->assertNotEmpty($sections[0]['items']);
        $this->assertArrayHasKey('title', $sections[0]);
        $this->assertArrayHasKey('description', $sections[0]);
    }
}
