<?php
/** This file is part of Single CTF Board
 * 
 * Copyright 2025 Petr Semendilov
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class SCTF_Config_Reader {
    public $parsed_config;
    function __construct($config_filepath = __DIR__ . '/../settings/config.json'){
        $config = file_get_contents($config_filepath);
        $this->parsed_config = json_decode($config, true);
    }

    private $name;
    function __get($name): string {
        return $this->parsed_config['info']['name'] ?? 'Single CTF Board';
    }

    function getTasks(): array {
        return $this->parsed_config['tasks'];
    }

    function getTask($num): array {
        return $this->getTasks()[$num - 1];
    }

    function verifyFlag($task_num, $flag): bool {
        $task = $this->getTask($task_num);
        $hash_alg = $this->parsed_config['info']['hash'];
        if ($hash_alg){
            $flag = hash($hash_alg, $flag);
        }
        return $task['flag'] == $flag;
    }
}