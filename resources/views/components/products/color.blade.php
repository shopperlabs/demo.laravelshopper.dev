@props(['product'])

<label aria-label="Washed Black"
    class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-700 focus:outline-none">
    <input type="radio" name="color-choice" value="Washed Black" class="sr-only">
    <span aria-hidden="true" class="size-8 bg-gray-700 border border-black rounded-full border-opacity-10"></span>
</label>
<!-- Active and Checked: "ring ring-offset-1" -->
<label aria-label="White"
    class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-400 focus:outline-none">
    <input type="radio" name="color-choice" value="White" class="sr-only">
    <span aria-hidden="true" class="size-8 bg-white border border-black rounded-full border-opacity-10"></span>
</label>
<!-- Active and Checked: "ring ring-offset-1" -->
<label aria-label="Washed Gray"
    class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 ring-gray-500 focus:outline-none">
    <input type="radio" name="color-choice" value="Washed Gray" class="sr-only">
    <span aria-hidden="true" class="size-8 bg-gray-500 border border-black rounded-full border-opacity-10"></span>
</label>
