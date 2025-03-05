<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <!-- Main Title -->
        <h1 class="text-4xl font-semibold text-center text-indigo-600 mb-4">Task List Manager</h1>

        <!-- Navigation -->
        <div class="mb-6">
            <nav class="flex justify-center space-x-6">
                <a href="index.php?action=add_list" class="text-blue-500 hover:text-blue-700 font-medium">Add Task List</a>
                <a href="index.php?action=view_lists" class="text-blue-500 hover:text-blue-700 font-medium">View Task Lists</a>
                <a href="index.php?action=clear_all" class="text-red-500 hover:text-red-700 font-medium" onclick="confirmClearAll(event)">Clear All Lists</a>
            </nav>
        </div>

        <!-- Separator -->
        <div class="mb-6">
            <hr class="border-t-2 border-indigo-200">
        </div>


        <script>
        // Function to ask for confirmation before clearing all lists
        function confirmClearAll(event) {
            const userConfirmed = confirm("Are you sure you want to clear all task lists?");
            if (!userConfirmed) {
                event.preventDefault(); // Prevent the default action (link click) if the user cancels
            }
        }
    </script>