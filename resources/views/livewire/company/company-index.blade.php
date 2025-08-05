<div class="dark:text-gray-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Companies</h1>
        <a href="{{ route('companies.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            + Add Company
        </a>
    </div>

    <div class="mb-4">
        <input
            type="search"
            placeholder="Search companies..."
            wire:model.live="search"
            class="w-full border border-gray-300 px-4 py-2 rounded-md shadow-sm"
        >
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-200">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-200">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-200">Phone</th>
                      <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-200">Add Seals</th>
                      <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-200">Add Signatures</th>
                      <th class="px-6 py-3 text-right text-xs font-medium uppercase text-gray-600 dark:text-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($companies as $company)
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-6 py-4">{{ $company->name }}</td>
                        <td class="px-6 py-4">{{ $company->email }}</td>
                        <td class="px-6 py-4">{{ $company->phone }}</td>
                         <td class="px-6 py-4">
                            <flux:button href="{{ route('companies.seal-upload', $company->id )}}"  variant="primary">
                                Add + 
                            </flux:button>
                         </td>
                          <td class="px-6 py-4">
                            <flux:button href="{{ route('companies.signature-upload', $company->id )}}"  variant="primary">
                                Add +
                            </flux:button>
                         </td>
                         
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center gap-2">
                            <a href="{{ route('companies.edit', $company->id) }}" class="text-blue-600 hover:underline btn btn-primary">
                                <flux:icon.pencil-square/>
                            </a>
                       @admin  <flux:icon.trash wire:click="delete({{ $company->id }})" 
                        wire:confirm="Are you sure you want to delete company: {{ $company->name }} ?" 
                        class="cursor-pointer text-red-600"
                        />@endadmin
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $companies->links() }}
    </div>
</div>
