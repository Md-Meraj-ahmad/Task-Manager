<?php
include('header.php');
include('task_manager.php');

// Action handling based on user input
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Creating a new task list
    if (isset($_POST['task_list_name'])) {
        create_task_list($_POST['task_list_name']);
    }
    // Adding a task to a specific task list
    elseif (isset($_POST['task']) && isset($_POST['list'])) {
        add_task($_POST['task'], $_POST['list']);
    }
}

switch ($action) {
    case 'add_list':
        ?>
        <div class="task-list-manager">
            <h2 class="text-2xl">Add a New Task List</h2>
            <form method="POST" action="index.php?action=add_list" class="space-y-4">
                <input type="text" name="task_list_name" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter Task List Name" required>
                <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 w-full">Add Task List</button>
            </form>
            <a href="index.php?action=view_lists" class="mt-4 text-blue-500 hover:text-blue-700 font-medium">View Task Lists</a>
        </div>
        <?php
        break;

    case 'view_lists':
        ?>
        <div class="task-list-manager">
        <!-- Section for Task Lists -->
        <section class="task-lists-section mb-6">
            <h2 class="text-2xl font-semibold mb-4">Task Lists:</h2>
            
            <?php
            $task_lists = get_task_lists();
            
            // If no task lists are found
            if (empty($task_lists)) {
                echo "<p class='text-gray-600 mb-4'>There are no task lists available.</p>";
            } else {
                // Display task lists in a select dropdown
                echo "<form method='GET' action='index.php' class='mb-6'>
                        <div class='flex items-center space-x-4'>
                            <select name='list' class='w-1/2 p-3 border border-gray-300 rounded-lg' required>
                                <option value=''>Select a Task List</option>";

                // Loop through the task lists and create an option for each list
                foreach ($task_lists as $list_name => $tasks) {
                    echo "<option value='$list_name'>" . htmlspecialchars($list_name) . "</option>";
                }

                echo "</select>";

                // Add a "View Tasks" button
                echo "<button type='submit' name='action' value='view_tasks' class='bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-700'>
                        View Tasks
                    </button>";

                // Add a "Delete List" button
                echo "<button type='submit' name='action' value='delete_list' class='bg-red-500 text-white p-3 rounded-lg hover:bg-red-700'>
                        Delete List
                    </button>";
                
                echo "</div>
                    </form>";
            }
            ?>
        </section>

        <!-- Section for Add Task List and Clear All Lists -->
        <section class="add-clear-section">
            <div class="flex justify-between items-center mt-4">
                <a href="index.php?action=add_list" class="text-blue-500 hover:text-blue-700 font-medium">Add Task List</a>
                <a href="index.php?action=clear_all" class="text-red-500 hover:text-red-700 font-medium">Clear All Lists</a>
            </div>
        </section>
    </div>


        <?php
        break;

    case 'view_tasks':
        $list_name = isset($_GET['list']) ? $_GET['list'] : '';
        if ($list_name && list_exists($list_name)) {
            ?>
            <div class="task-list-manager">
                <h2 class="text-2xl"><?= htmlspecialchars($list_name) ?> Tasks:</h2>
                <form method="POST" action="index.php?action=view_tasks&list=<?= $list_name ?>" class="space-y-4">
                    <input type="text" name="task" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Enter Task" required>
                    <input type="hidden" name="list" value="<?= $list_name ?>">
                    <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 w-full">Add Task</button>
                </form>

                <?php
                if (isset($_SESSION['task_lists'][$list_name]) && count($_SESSION['task_lists'][$list_name]) > 0) {
                    echo "<ul class='space-y-4'>";
                    foreach ($_SESSION['task_lists'][$list_name] as $index => $task) {
                        echo "<li class='flex justify-between items-center bg-gray-50 p-4 rounded-lg'>
                                <span>" . ($task) . "</span>
                                <a href='index.php?action=delete_task&list=$list_name&index=$index' class='text-red-500 hover:text-red-700'>Delete</a>
                            </li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>There are no tasks in this task list.</p>";
                }
                ?>

                <!-- Section for Add Task List and Clear All Lists -->
                <section class="add-clear-section">
                    <div class="flex justify-between items-center mt-4">
                        <a href="index.php?action=add_list" class="mt-4 text-blue-500 hover:text-blue-700 font-medium">Add New Task List</a>
                        <a href="index.php?action=clear_all" class="mt-4 text-red-500 hover:text-red-700 font-medium">Clear List</a>
                    </div>
                </section>
            </div>
            <?php
        }
        break;

    case 'delete_task':
        if (isset($_GET['list']) && isset($_GET['index'])) {
            $list_name = $_GET['list'];
            $index = $_GET['index'];
            delete_task($index, $list_name);
            header("Location: index.php?action=view_tasks&list=$list_name"); // Redirect after deletion
            exit;
        }
        break;

    case 'delete_list':
        if (isset($_GET['list'])) {
            $list_name = $_GET['list'];
            delete_task_list($list_name);
            header("Location: index.php?action=view_lists"); // Redirect after list deletion
            exit;
        }
        break;

    case 'clear_all':
        clear_all_tasks();
        header("Location: index.php?action=view_lists"); // Redirect after clearing all tasks
        exit;
        break;

    default:
        echo "<p class='text-center text-lg text-gray-700'>Welcome to the Task List Manager! Please select an option above.</p>";
        break;
}

include('footer.php');
?>
