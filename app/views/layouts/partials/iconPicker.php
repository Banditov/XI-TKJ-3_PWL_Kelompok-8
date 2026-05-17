<!-- Icon Picker -->
<div class="w-screen h-screen bg-black/50 backdrop-blur-2xl z-10 flex justify-center items-center fixed top-0 left-0 hidden" id="iconPicker">
    <div id="iconPick" class="w-100 bg-white rounded-4xl p-5 flex flex-col gap-5 text-[#545F71] items-center">
        <div class="flex justify-between border-b-2 border-[#545F71] pb-2 w-full">
            <p>Icons</p>
            <?= essIcon('x', 'w-6 h-6 cursor-pointer close-icon-picker') ?>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php foreach (icon() as $i): ?>
                <div class="iconOption cursor-pointer p-1 rounded-lg hover:bg-gray-100" data-icon="<?= $i ?>">
                    <?= icon($i, 'w-6 h-6') ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>