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

require_once __DIR__ . '/../src/config_reader.php';
require_once __DIR__ . '/../src/task_renderer.php';
require_once __DIR__ . '/../src/task_db.php';
$db = new SCTF_DB();
$cfg = new SCTF_Config_Reader();
$name = $cfg->name;
$tasks = $cfg->getTasks();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['task']) && !empty($_POST['task']) && isset($_POST['flag']) && !empty($_POST['flag'])){
        $db->setTaskStatus($_POST['task'], $cfg->verifyFlag($_POST['task'], $_POST['flag']) ? 2 : -1);
    }
    http_response_code(302);
    header('Location: '. $_SERVER['REQUEST_URI']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=block,check,lock" />
</head>

<body>
    <div class="container">
        <div class="row" style="margin-bottom: 10px;">
            <h1><?php echo $name; ?></h1>
            <div class="task-indicator">
                <?php echo $db->getCompletedTasksCount() . '/' . count($tasks); ?> completed
            </div>
        </div>
        <?php
        $last_task_status = null;
        foreach ($tasks as $num=>$task) {
            $num++;
            $status = $db->getTaskStatus($num)['status'] ?? (($last_task_status === SCTF_TASK_SUCCESS || $last_task_status === null) ? SCTF_TASK_CURRENT : SCTF_TASK_LOCKED);
            TaskRenderer::render($num, $task, $status);
            $last_task_status = $status;
        }
        ?>
        <a href="https://github.com/petrsempet/Single-CTF-Board" class="copyright">Single CTF Board by Petr
            Semendilov</a>
    </div>
</body>

</html>