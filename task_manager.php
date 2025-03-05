<?php
session_start();

// Add a new task to a specific task list
function add_task($task, $list) {
    if (!isset($_SESSION['task_lists'][$list])) {
        $_SESSION['task_lists'][$list] = array(); // Create the list if it doesn't exist
    }

    // Sanitize task input to prevent XSS
    $task = htmlspecialchars($task);

    // Add the task to the selected list
    $_SESSION['task_lists'][$list][] = $task;
}

// Delete a task from a specific task list
function delete_task($index, $list) {
    if (isset($_SESSION['task_lists'][$list][$index])) {
        unset($_SESSION['task_lists'][$list][$index]);
        $_SESSION['task_lists'][$list] = array_values($_SESSION['task_lists'][$list]); // Reindex the array
    }
}

// Create a new task list
function create_task_list($list_name) {
    $list_name = htmlspecialchars($list_name); // Sanitize the list name to prevent issues with invalid characters

    if (!isset($_SESSION['task_lists'][$list_name])) {
        $_SESSION['task_lists'][$list_name] = array(); // Initialize the new list
    }
}

// Delete a task list and all tasks inside it
function delete_task_list($list_name) {
    if (isset($_SESSION['task_lists'][$list_name])) {
        unset($_SESSION['task_lists'][$list_name]); // Delete the list and its tasks
    }
}

// Clear all task lists and their tasks
function clear_all_tasks() {
    unset($_SESSION['task_lists']); // Remove all task lists
}

// Get all task lists
function get_task_lists() {
    return isset($_SESSION['task_lists']) ? $_SESSION['task_lists'] : array();
}

// Check if a task list exists
function list_exists($list_name) {
    return isset($_SESSION['task_lists'][$list_name]);
}

?>
