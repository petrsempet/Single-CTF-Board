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

define('SCTF_TASK_FAILED', -1);
define('SCTF_TASK_SUCCESS', 2);
define('SCTF_TASK_CURRENT', 1);
define('SCTF_TASK_LOCKED', 0);

class SCTF_DB extends SQLite3 {
    function __construct($filename = __DIR__ . '/../settings/answers.db'){
        $this->open($filename);
    }

    function getTaskStatus($task_num): array|bool {
        $stmt = $this->prepare('SELECT status, timestamp FROM answers WHERE task = :task_num ORDER BY id DESC LIMIT 1;');
        $stmt->bindValue(':task_num', $task_num);
        $res = $stmt->execute();
        $status = $res->fetchArray(SQLITE3_ASSOC);
        return $status;
    }

    function setTaskStatus($task_num, $status, $check_last_status = true): bool {
        if ($check_last_status){
            $res = $this->getTaskStatus($task_num);
            if (isset($res['status']) && $res['status'] == SCTF_TASK_SUCCESS){
                return false;
            }
        }
        $stmt = $this->prepare('INSERT INTO answers (status, task) VALUES (:status, :task);');
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':task', $task_num);
        $stmt->execute();
        return true;
    }

    function getCompletedTasksCount(): int{
        return $this->query('SELECT COUNT(*) FROM answers WHERE status = 2;')->fetchArray()[0] ?? 0;
    }
}