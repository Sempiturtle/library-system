<h2 class="text-2xl font-bold mb-4">Borrow History</h2>

<table class="w-full border-collapse">
    <tr class="bg-indigo-500 text-white">
        <th class="p-2">Book</th>
        <th class="p-2">Borrowed</th>
        <th class="p-2">Due</th>
        <th class="p-2">Returned</th>
        <th class="p-2">Penalty</th>
    </tr>

    @foreach($history as $item)
    <tr class="border-b">
        <td class="p-2">{{ $item->book->title }}</td>
        <td class="p-2">{{ $item->borrow_date->format('M d, Y') }}</td>
        <td class="p-2">{{ $item->due_date->format('M d, Y') }}</td>
        <td class="p-2">
            {{ $item->return_date ? $item->return_date->format('M d, Y') : 'Not Returned' }}
        </td>
        <td class="p-2">
            {{ $item->penalty_fee ? '₱'.$item->penalty_fee : '-' }}
        </td>
    </tr>
    @endforeach
</table>
