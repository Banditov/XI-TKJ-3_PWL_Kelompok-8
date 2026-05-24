<title>Class Agenda | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white dark:bg-[#1B1B1B] text-[#545F71] dark:text-white drop-shadow-lg p-10 post">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-bold text-[#2C7CFF]">Class Agenda</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your tasks and assignments</p>
            </div>
            <div class="flex gap-3">
                <?php if ($isTeacher && !empty($availableClasses)): ?>
                    <select id="classFilter" onchange="filterByClass(this.value)"
                        class="px-4 py-2 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] cursor-pointer">
                        <?php foreach ($availableClasses as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= ($classId == $class['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <button onclick="openAddModal()"
                    class="px-5 py-2 bg-[#2C7CFF] text-white rounded-xl hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition-all duration-300 flex items-center gap-2">
                    <?= essIcon('x', 'w-6 h-6 transform rotate-45') ?>
                    Add Task
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                        <?= essIcon('task', 'w-5 h-5 text-blue-600 dark:text-blue-300') ?>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-300"><?= count($currentAgenda) ?></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Current Tasks</p>
                    </div>
                </div>
            </div>
            <div
                class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-4 border border-orange-200 dark:border-orange-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-orange-100 dark:bg-orange-800 rounded-full flex items-center justify-center">
                        <?= icon('time', 'w-6 h-6 text-orange-600 dark:text-orange-300') ?>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-orange-600 dark:text-orange-300">
                            <?php
                            $dueToday = 0;
                            $today = date('Y-m-d');
                            foreach ($currentAgenda as $item) {
                                if ($item['due_date'] == $today)
                                    $dueToday++;
                            }
                            echo $dueToday;
                            ?>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Due Today</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                        <?= essIcon('correct', 'w-5 h-5 text-green-600 dark:text-green-300') ?>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-300"><?= count($passedAgenda) ?></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Passed Tasks</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Tasks -->
        <div class="mb-6">
            <button onclick="toggleSection('currentTasks')" class="flex items-center w-full group mb-5 gap-5 hover:bg-transparent!">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-[#2C7CFF] rounded-full"></div>
                    <h2 class="text-2xl font-bold">Current Tasks</h2>
                </div>
                <div class="transition-transform duration-300" id="currentTasksArrow">
                    <?= essIcon('arrow', 'w-6 h-6 text-gray-500') ?>
                </div>
            </button>

            <div id="currentTasksContent">
                <?php if (empty($currentAgenda)): ?>
                    <div
                        class="py-12 bg-gray-50 dark:bg-gray-800/30 rounded-2xl flex flex-col items-center justify-center gap-4">
                        <?= essIcon('task', 'w-10 h-10 text-gray-400') ?>
                        <p class="text-gray-500">No upcoming tasks.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach ($currentAgenda as $item): ?>
                            <?php
                            $dueDate = strtotime($item['due_date']);
                            $today = strtotime(date('Y-m-d'));
                            $daysLeft = ceil(($dueDate - $today) / 86400);
                            ?>
                            <div
                                class="group bg-white dark:bg-[#1B1B1B] border border-gray-200 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-all duration-300">
                                <div class="flex justify-between items-start gap-4 mb-3">
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <h3 class="text-xl font-bold"><?= htmlspecialchars($item['title']) ?></h3>
                                            <div class="flex items-center gap-3 text-xs">
                                                <div
                                                    class="flex items-center gap-1 <?= $daysLeft == 0 ? 'text-orange-600 dark:text-orange-400 font-bold' : 'text-gray-500' ?>">
                                                    <?= essIcon('calendar', 'w-3 h-3') ?>
                                                    <span><?= date('M d, Y', strtotime($item['due_date'])) ?></span>
                                                </div>
                                                <div class="flex items-center gap-1 text-gray-400">
                                                    <?= essIcon('person', 'w-3 h-3') ?>
                                                    <p>●</p>
                                                    <span class="font-medium">Added by:</span>
                                                    <span><?= htmlspecialchars($item['creator_name']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="openEditModal(<?= $item['id'] ?>)"
                                            class="text-blue-500 hover:text-blue-700 dark:hover:**:text-blue-500! transition-colors flex items-center gap-1 cursor-pointer">
                                            <?= essIcon('create', 'w-4 h-4') ?>
                                            <span class="text-sm">Edit</span>
                                        </button>
                                        <button type="button" onclick="showDeleteTaskModal(<?= $item['id'] ?>)"
                                            class="text-red-500 hover:text-red-700 dark:hover:**:text-red-500! transition-colors flex items-center gap-1 cursor-pointer">
                                            <?= essIcon('delete', 'w-4 h-4') ?>
                                            <span class="text-sm">Delete</span>
                                        </button>
                                        <form id="deleteTaskForm-<?= $item['id'] ?>" action="/agenda/<?= $item['id'] ?>/delete"
                                            method="POST" class="hidden"></form>
                                    </div>
                                </div>
                                <?php if ($item['description']): ?>
                                    <div class="mb-3">
                                        <p class="text-gray-500 dark:text-gray-400 text-sm text-justify">
                                            <?= nl2br(htmlspecialchars($item['description'])) ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if ($item['tags']): ?>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $item['tags']) as $tag): ?>
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-800! rounded-lg text-xs text-gray-600 transition">#<?= htmlspecialchars(trim($tag)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Passed -->
        <?php if (!empty($passedAgenda)): ?>
            <div class="mt-8">
                <button onclick="toggleSection('passedTasks')" class="flex items-center w-full group mb-5 gap-5 hover:bg-transparent!">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-8 bg-gray-500 rounded-full"></div>
                        <h2 class="text-2xl font-bold">Passed Tasks</h2>
                    </div>
                    <div class="transition-transform duration-300" id="passedTasksArrow">
                        <?= essIcon('arrow', 'w-6 h-6 text-gray-500') ?>
                    </div>
                </button>

                <div id="passedTasksContent">
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach ($passedAgenda as $item): ?>
                            <div
                                class="group bg-white dark:bg-[#1B1B1B] border border-gray-200 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-all duration-300">
                                <div class="flex justify-between items-start gap-4 mb-3">
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <h3 class="text-xl font-bold text-gray-500"><?= htmlspecialchars($item['title']) ?>
                                            </h3>
                                            <div class="flex items-center gap-3 text-xs">
                                                <div class="flex items-center gap-1 text-red-500">
                                                    <?= essIcon('calendar', 'w-3 h-3') ?>
                                                    <span>Passed: <?= date('M d, Y', strtotime($item['due_date'])) ?></span>
                                                </div>
                                                <div class="flex items-center gap-1 text-gray-400">
                                                    <?= essIcon('person', 'w-3 h-3') ?>
                                                    <p>●</p>
                                                    <span class="font-medium">Added by:</span>
                                                    <span><?= htmlspecialchars($item['creator_name']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick="openEditModal(<?= $item['id'] ?>)"
                                            class="text-blue-500 hover:text-blue-700 dark:hover:**:text-blue-500! transition-colors flex items-center gap-1 cursor-pointer">
                                            <?= essIcon('create', 'w-4 h-4') ?>
                                            <span class="text-sm">Edit</span>
                                        </button>
                                        <button type="button" onclick="showDeleteTaskModal(<?= $item['id'] ?>)"
                                            class="text-red-500 hover:text-red-700 dark:hover:**:text-red-500! transition-colors flex items-center gap-1 cursor-pointer">
                                            <?= essIcon('delete', 'w-4 h-4') ?>
                                            <span class="text-sm">Delete</span>
                                        </button>
                                        <form id="deleteTaskForm-<?= $item['id'] ?>" action="/agenda/<?= $item['id'] ?>/delete"
                                            method="POST" class="hidden"></form>
                                    </div>
                                </div>
                                <?php if ($item['description']): ?>
                                    <div class="mb-3">
                                        <p class="text-gray-400 text-sm text-justify">
                                            <?= nl2br(htmlspecialchars($item['description'])) ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if ($item['tags']): ?>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $item['tags']) as $tag): ?>
                                            <span
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-800! rounded-lg text-xs text-gray-600 transition">#<?= htmlspecialchars(trim($tag)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Add Task Modal -->
<div id="addModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
    <div class="w-96 bg-white dark:bg-[#1B1B1B] rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0 overflow-hidden"
        id="addModalContent">
        <div
            class="flex justify-between items-center py-4 px-6 border-b text-gray-500 border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold">Add New Task</h2>
            <button onclick="closeAddModal()" class="hover:text-gray-700 dark:hover:text-gray-300 transition">
                <?= essIcon('x', 'w-6 h-6') ?>
            </button>
        </div>
        <form action="/agenda/store" method="POST" class="p-6 flex flex-col gap-4">
            <?php if ($isTeacher && !empty($availableClasses)): ?>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                    <select name="class_id"
                        class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
                        <?php foreach ($availableClasses as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title <span
                        class="text-red-500">*</span></label>
                <input type="text" name="title" required
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" rows="3"
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition"></textarea>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                <input type="text" name="tags" placeholder="Homework, Project, Quiz"
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Due Date <span
                        class="text-red-500">*</span></label>
                <input type="date" name="due_date" required
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
            </div>
            <button type="submit"
                class="mt-2 px-4 py-3 bg-[#2C7CFF] text-white rounded-xl hover:bg-[#1a5bc4] transition-all duration-300 font-medium cursor-pointer">
                Add to Agenda
            </button>
        </form>
    </div>
</div>

<!-- Edit Task Modal -->
<div id="editModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
    <div class="w-96 bg-white dark:bg-[#1B1B1B] rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0 overflow-hidden"
        id="editModalContent">
        <div
            class="flex justify-between items-center py-4 px-6 border-b text-gray-500 border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold">Edit Task</h2>
            <button onclick="closeEditModal()" class="hover:text-gray-700 dark:hover:text-gray-300 transition">
                <?= essIcon('x', 'w-6 h-6') ?>
            </button>
        </div>
        <form id="editTaskForm" method="POST" class="p-6 flex flex-col gap-4">
            <input type="hidden" name="task_id" id="edit_task_id">
            <?php if ($isTeacher && !empty($availableClasses)): ?>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                    <select name="class_id" id="edit_class_id"
                        class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
                        <?php foreach ($availableClasses as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title <span
                        class="text-red-500">*</span></label>
                <input type="text" name="title" id="edit_title" required
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="edit_description" rows="3"
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition"></textarea>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                <input type="text" name="tags" id="edit_tags" placeholder="Homework, Project, Quiz"
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Due Date <span
                        class="text-red-500">*</span></label>
                <input type="date" name="due_date" id="edit_due_date" required
                    class="w-full p-3 rounded-xl border border-gray-300 dark:bg-[#2C2C2C] dark:border-[#3F3F3F] focus:outline-none focus:ring-2 focus:ring-[#2C7CFF] transition">
            </div>
            <div class="flex gap-3 mt-2">
                <button type="submit"
                    class="flex-1 px-4 py-3 bg-[#2C7CFF] text-white rounded-xl hover:bg-[#1a5bc4] transition-all duration-300 font-medium cursor-pointer">
                    Update Task
                </button>
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 px-4 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 font-medium cursor-pointer">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/js/agenda.js"></script>