<form method="POST" action="{{ route('filament.resources.addresses.update-results', $address) }}">
    @csrf
    <div class="space-y-4">
        <h2 class="text-lg font-semibold">Resultate für {{ $address->name }}</h2>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm text-gray-500">Method</th>
                    <th class="px-4 py-2 text-left text-sm text-gray-500">Wert</th>
                    <th class="px-4 py-2 text-left text-sm text-gray-500">Einheit</th>
                    <th class="px-4 py-2 text-left text-sm text-gray-500">Gerät</th>
                    <th class="px-4 py-2 text-left text-sm text-gray-500">Gerätenummer</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($results as $result)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $result->method_id }}</td>
                        <td class="px-4 py-2">
                            <input type="text" name="values[{{ $result->id }}]" value="{{ $result->value }}"
                                   class="w-full border border-gray-300 rounded px-2 py-1 text-sm" />
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $result->unit_id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $result->device_id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $result->device_num }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pt-4">
            <x-filament::button type="submit">Speichern</x-filament::button>
        </div>
    </div>
</form>