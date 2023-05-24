@props(['message'])
<div id="alert" class="flex p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
    role="alert">
    <span class="sr-only">Info</span>
    <div class="ml-3 text-sm font-medium">
        {{ $message }}
    </div>
</div>
