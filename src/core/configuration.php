<?php
/**
 * FastBlog | configuration.php
 * Configuration
 * License: BSD-2-Clause
 */

namespace FastBlog\Core;

class Configuration {

    private $config;

    public function __construct() {
        $this->load();
    }

    private function load() {
        $file = file_get_contents('configuration/config.json', true);
        $config = json_decode($file, true);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }
}
