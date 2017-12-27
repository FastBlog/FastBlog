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

    /**
     * Load the json configuration file as an array
     */
    private function load() {
        $file = file_get_contents('configuration/config.json', true);
        $this->config = json_decode($file, true);
    }

    /**
     * Return the array of configuration values
     * @return mixed
     */
    public function getConfig() {
        return $this->config;
    }
}
