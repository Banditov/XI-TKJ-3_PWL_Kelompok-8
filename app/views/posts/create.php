<title>Create Post | ImmaSpark</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar/navbar.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:container md:mx-auto">
    <diV>
        <p class="text-4xl font-bold">Create Post</p>
        <form action="/posts" method="POST" class="flex flex-col gap-5">
            <input type="text" name="title" placeholder="Title" class="p-4 w-full text-white rounded-full bg-clip-padding backdrop-filter backdrop-blur-md bg-opacity-10 border border-gray-100">
            <textarea id="mytextarea">Hello, World!</textarea>
            <button type="submit" class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-max self-end">Submit</button>
        </form>
    </diV>
</main>

<script src="/js/library/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce.js"></script>