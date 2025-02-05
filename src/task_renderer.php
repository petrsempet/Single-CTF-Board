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

require_once __DIR__ . '/task_db.php';
require __DIR__ . '/../vendor/autoload.php';
class TaskRenderer
{
    static function render(int $task_num, array $task, int $status = null)
    {
        switch ((int)$status) {
            case SCTF_TASK_CURRENT:
                $classname = '';
                $title = 'Текущее задание / Current task';
                break;
            case SCTF_TASK_FAILED:
                $classname = 'failed';
                $title = 'Неверный флаг / Incorrect flag';
                break;
            case SCTF_TASK_SUCCESS:
                $classname = 'completed';
                $title = 'Задание выполнено / Task completed';
                break;
            case SCTF_TASK_LOCKED:
                $classname = 'locked';
                $title = 'Задание откроется после выполнения предыдущего / The task will open after completing the previous';
                break;
        }
        $parsedown = new Parsedown();
        ?>
        <div class="task-card <?php echo htmlentities($classname ?? ''); ?>" title="<?php echo htmlentities($title ?? ''); ?>">
            <div class="task-card-header">
                <h2><?php echo $task_num . '. ' . $task['name']; ?></h2>
                <span class="material-symbols-outlined icon"></span>
            </div>
            <?php if ($status != SCTF_TASK_LOCKED && $status != SCTF_TASK_SUCCESS) { ?>
            <div class="task-card-body">
                <?php echo $parsedown->text($task['description']); ?>
                <h3 class="mrg-top">Подключение / Connection:</h3>
                <pre><?php echo htmlentities($task['connection'] ?? ''); ?></pre>
                <form method="post" class="mrg-top">
                    <h3>Флаг / Flag</h3>
                    <input type="hidden" name="task" value="<?php echo $task_num; ?>">
                    <input name="flag" placeholder="<?php echo htmlentities($task['flag_format'] ?? 'CTF{..}'); ?>">
                    <button type="submit">Отправить / Submit</button>
                </form>
            </div>
            <?php } ?>
        </div>
        <?php
    }
}