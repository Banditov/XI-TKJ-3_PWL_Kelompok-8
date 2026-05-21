<title>Register New User | Admin Panel</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>
<?php include __DIR__ . '/../../../app/helpers/basehelper.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white dark:bg-[#1B1B1B] text-[#545F71] drop-shadow-lg p-10 post">
        <h1 class="text-4xl font-bold mb-6">Register New User</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="/admin/register/create" method="POST" class="flex flex-col gap-5" enctype="multipart/form-data">
            <div class="flex flex-col gap-2 items-center">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=User&background=2C7CFF&color=fff&size=100&bold=true"
                        id="avatarPreview" class="w-24 h-24 object-cover rounded-full">
                    <button type="button" onclick="document.getElementById('avatarInput').click()"
                        class="absolute bottom-0 right-0 bg-white text-[#545F71] p-2 rounded-full">
                        <?= icon('pencil', 'w-4 h-4') ?>
                    </button>
                </div>
                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden"
                    onchange="previewAvatar(this)">
                <p class="text-sm text-gray-500">Upload profile picture (Max 10MB)</p>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-2xl font-bold">Name</label>
                <input type="text" name="name" required
                    class="p-4 w-full text-gray-700 dark:text-white dark:bg-[#2C2C2C] rounded-full border border-gray-500 dark:border-[#3F3F3F]">
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-2xl font-bold">Email</label>
                <input type="email" name="email" required
                    class="p-4 w-full text-gray-700 dark:text-white dark:bg-[#2C2C2C] rounded-full border border-gray-500 dark:border-[#3F3F3F]">
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-2xl font-bold">Password</label>
                <input type="password" name="password" required
                    class="p-4 w-full text-gray-700 dark:text-white dark:bg-[#2C2C2C] rounded-full border border-gray-500 dark:border-[#3F3F3F]">
                <p class="text-sm text-gray-500">Minimum 4 characters</p>
            </div>

            <div class="flex flex-col gap-2">
                <label class="text-2xl font-bold">Class</label>
                <select name="class_id" required
                    class="p-4 w-full text-gray-700 dark:text-white dark:bg-[#2C2C2C] rounded-full border border-gray-500 dark:border-[#3F3F3F]">
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_admin" value="1" class="w-5 h-5">
                    <span class="text-2xl font-bold">Admin Privileges</span>
                </label>
                <p class="text-sm text-gray-500">Admin users can access admin panel and manage other users</p>
            </div>

            <div class="flex gap-4 w-full flex-col mt-4">
                <button type="submit"
                    class="px-6 py-3 bg-[#2C7CFF] text-white rounded-full w-full cursor-pointer hover:bg-white hover:text-[#2C7CFF] hover:ring-2 transition">
                    Create User
                </button>
                <a href="/admin/users"
                    class="text-[#545F71] dark:text-white rounded-full w-full text-center hover:underline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</main>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>