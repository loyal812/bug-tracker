<div class="mt-4 p-4 bg-white rounded shadow">
    <form hx-post="/core/report_bug.php" hx-target="#notification" hx-swap="innerHTML">
        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input id="id_title" type="text" name="title" class="mt-1 p-2 border rounded w-full">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" class="mt-1 p-2 border rounded w-full"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Urgency</label>
            <select name="urgency" class="mt-1 p-2 border rounded w-full">
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
            </select>
        </div>
        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Submit</button>
    </form>
</div>