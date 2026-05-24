<?php
namespace app\controllers;

use app\core\controller;
use app\models\agenda;
use app\models\classes;

class agendacontroller extends controller
{
    public function index()
    {
        $this->requireLogin();

        $classId = $_SESSION['class_id'] ?? 0;
        $userClass = $_SESSION['class_name'] ?? '';
        $isTeacher = ($userClass === 'Guru' || ($_SESSION['is_admin'] ?? 0) == 1);

        if (isset($_GET['class']) && is_numeric($_GET['class'])) {
            $_SESSION['agenda_selected_class'] = intval($_GET['class']);
        }

        $selectedClass = $_SESSION['agenda_selected_class'] ?? 0;

        if ($isTeacher && $selectedClass > 0) {
            $classId = $selectedClass;
        } elseif (!$isTeacher) {
            $classId = $_SESSION['class_id'] ?? 0;
        }

        $classModel = new classes();
        $allClasses = $classModel->getAllClasses();
        $availableClasses = array_filter($allClasses, function ($class) {
            return $class['name'] !== 'Guru';
        });

        $agendaModel = new agenda();

        if ($isTeacher && $classId > 0) {
            $currentAgenda = $agendaModel->getCurrentAgendaByClass($classId);
            $passedAgenda = $agendaModel->getPassedAgendaByClass($classId);
        } else {
            $currentAgenda = $agendaModel->getCurrentAgendaByClass($classId);
            $passedAgenda = $agendaModel->getPassedAgendaByClass($classId);
        }

        $this->view('agenda.index', [
            'currentAgenda' => $currentAgenda,
            'passedAgenda' => $passedAgenda,
            'classId' => $classId,
            'isTeacher' => $isTeacher,
            'availableClasses' => array_values($availableClasses)
        ]);
    }

    public function store()
    {
        $this->requireLogin();

        $userClass = $_SESSION['class_name'] ?? '';
        $isTeacher = ($userClass === 'Guru' || ($_SESSION['is_admin'] ?? 0) == 1);

        $classId = intval($_POST['class_id'] ?? 0);

        if (!$isTeacher || $classId <= 0) {
            $classId = $_SESSION['class_id'] ?? 0;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $dueDate = $_POST['due_date'] ?? '';

        if (empty($title)) {
            $_SESSION['error'] = 'Title is required';
            header("Location: /agenda");
            exit;
        }

        if (empty($dueDate)) {
            $_SESSION['error'] = 'Due date is required';
            header("Location: /agenda");
            exit;
        }

        if ($classId <= 0) {
            $_SESSION['error'] = 'Invalid class selected';
            header("Location: /agenda");
            exit;
        }

        $agendaModel = new agenda();
        $result = $agendaModel->createAgenda($classId, $_SESSION['account_id'], $title, $description, $tags, $dueDate);

        if ($result) {
            $_SESSION['success'] = 'Task added to agenda!';
        } else {
            $_SESSION['error'] = 'Failed to add task';
        }

        header("Location: /agenda");
        exit;
    }

    public function delete(string $id)
    {
        $this->requireLogin();

        $agendaModel = new agenda();
        $item = $agendaModel->getAgendaItem(intval($id));
        $userClass = $_SESSION['class_name'] ?? '';
        $isTeacher = ($userClass === 'Guru' || ($_SESSION['is_admin'] ?? 0) == 1);

        if (!$item) {
            header("Location: /agenda");
            exit;
        }

        if ($isTeacher || $item['account_id'] == $_SESSION['account_id']) {
            $agendaModel->deleteAgenda(intval($id), $item['account_id']);
        }

        header("Location: /agenda");
        exit;
    }

    public function edit(string $id)
    {
        $this->requireLogin();

        $agendaModel = new agenda();
        $task = $agendaModel->getAgendaItem(intval($id));

        if (!$task) {
            header("Location: /agenda");
            exit;
        }

        $isOwner = ($task['account_id'] == $_SESSION['account_id']);
        $isTeacher = ($_SESSION['class_name'] ?? '') === 'Guru' || ($_SESSION['is_admin'] ?? 0) == 1;

        if (!$isOwner && !$isTeacher) {
            $_SESSION['error'] = 'You cannot edit this task';
            header("Location: /agenda");
            exit;
        }

        $classModel = new classes();
        $allClasses = $classModel->getAllClasses();
        $availableClasses = array_filter($allClasses, function ($class) {
            return $class['name'] !== 'Guru';
        });

        $this->view('agenda.edit', [
            'task' => $task,
            'availableClasses' => array_values($availableClasses),
            'isTeacher' => $isTeacher
        ]);
    }

    public function update(string $id)
    {
        $this->requireLogin();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        $agendaModel = new agenda();
        $task = $agendaModel->getAgendaItem(intval($id));

        if (!$task) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'Task not found']);
                exit;
            }
            header("Location: /agenda");
            exit;
        }

        $isOwner = ($task['account_id'] == $_SESSION['account_id']);
        $isTeacher = ($_SESSION['class_name'] ?? '') === 'Guru' || ($_SESSION['is_admin'] ?? 0) == 1;

        if (!$isOwner && !$isTeacher) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }
            $_SESSION['error'] = 'You cannot edit this task';
            header("Location: /agenda");
            exit;
        }

        $classId = intval($_POST['class_id'] ?? $task['class_id']);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $dueDate = $_POST['due_date'] ?? '';

        if (empty($title)) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'Title is required']);
                exit;
            }
            $_SESSION['error'] = 'Title is required';
            header("Location: /agenda/{$id}/edit");
            exit;
        }

        if (empty($dueDate)) {
            if ($isAjax) {
                echo json_encode(['success' => false, 'error' => 'Due date is required']);
                exit;
            }
            $_SESSION['error'] = 'Due date is required';
            header("Location: /agenda/{$id}/edit");
            exit;
        }

        $result = $agendaModel->updateAgenda(intval($id), $classId, $title, $description, $tags, $dueDate);

        if ($isAjax) {
            echo json_encode(['success' => $result, 'error' => $result ? null : 'Failed to update task']);
            exit;
        }

        if ($result) {
            $_SESSION['success'] = 'Task updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update task';
        }

        $redirectClass = $classId != $task['class_id'] ? '?class=' . $classId : '';
        header("Location: /agenda" . $redirectClass);
        exit;
    }

    public function getTaskData(string $id)
    {
        $this->requireLogin();

        $agendaModel = new agenda();
        $task = $agendaModel->getAgendaItem(intval($id));

        if (!$task) {
            echo json_encode(['success' => false, 'error' => 'Task not found']);
            exit;
        }

        $isOwner = ($task['account_id'] == $_SESSION['account_id']);
        $isTeacher = ($_SESSION['class_name'] ?? '') === 'Guru' || ($_SESSION['is_admin'] ?? 0) == 1;

        if (!$isOwner && !$isTeacher) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }

        echo json_encode([
            'success' => true,
            'task' => [
                'id' => $task['id'],
                'class_id' => $task['class_id'],
                'title' => $task['title'],
                'description' => $task['description'],
                'tags' => $task['tags'],
                'due_date' => $task['due_date']
            ]
        ]);
        exit;
    }
}