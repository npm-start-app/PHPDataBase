<?php try {
    if (!isset($_error_code)) {die();}
    if (!isset($_error_h)) {die();}
    if (!isset($_error_msg)) {die();}
    if (!isset($_error_redirect)) {die();}
} catch (Throwable $__e) { die(); } ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body>
    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-base font-semibold text-indigo-600"><?php echo $_error_code ?></p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl"><?php echo $_error_h ?></h1>
            <p class="mt-6 text-base leading-7 text-gray-600"><?php echo $_error_msg ?></p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="<?php echo $_error_redirect ?>" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Main Page</a>
            </div>
        </div>
    </main>
</body>

</html>