<div class="md:p-8 space-y-6">
    <flux:heading class="text-3xl!">Posts List</flux:heading>

    <x-internship.filter-search/>

    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl">
        <div class="overflow-hidden w-full overflow-x-auto rounded-radius">
            <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                <thead class="border-b border-outline bg-surface-alt dark:border-outline-dark dark:bg-surface-dark-alt">
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Job Title</th>
                    <th class="p-4">Likes</th>
                    <th class="p-4">Author</th>
                    <th class="p-4">Address</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Major</th>
                    <th class="p-4">Created</th>
                    <th class="p-4 text-right">Action</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse($posts as $i => $post)
                    <tr class="even:bg-primary/5 dark:even:bg-primary-dark/10">
                        <td class="p-4">{{ $posts->firstItem() + $i }}</td>
                        <td class="p-4">{{ $post->job_title }}</td>
                        <td class="p-4">{{ $post->likes_count }}</td>
                        <td class="p-4">{{ $post->author->name ?? '-' }}</td>
                        <td class="p-4">{{ $post->location ?? '-' }}</td>
                        <td class="p-4">
                            @php
                                $statusLabel = $post->status->status ?? ($post->deleted_at ? 'Deleted' : '-');
                                $statusLower = strtolower($statusLabel);
                                $badgeColor = match($statusLower) {
                                    'approved' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                    'pending' => 'bg-blue-500',
                                    'banned' => 'bg-zinc-700',
                                    'deleted' => 'bg-gray-500',
                                    default => 'bg-zinc-400',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded text-white {{ $badgeColor }}">
                                {{ ucfirst($statusLabel) }}
                            </span>
                        </td>
                        <td class="p-4">{{ $post->vocationalMajor->major_name ?? '-' }}</td>
                        <td class="p-4">{{ optional($post->created_at)->toDateString() }}</td>
                        <td class="p-4">
                            @php
                                $deleted = !is_null($post->deleted_at);
                                $current = strtolower($post->status->status ?? '');
                                $options = [];
                                if ($deleted) {
                                    $options = ['deleted' => 'Deleted'];
                                } elseif ($current === 'pending' || $current === '') {
                                    $options = [
                                        'approved' => 'Approve',
                                        'rejected' => 'Reject',
                                    ];
                                } elseif (in_array($current, ['approved','rejected','banned'])) {
                                    $options = [
                                        'approved' => 'Approve',
                                        'rejected' => 'Reject',
                                        'banned' => 'Ban',
                                    ];
                                }
                                $disabled = !$canManage || $deleted;
                            @endphp
                            <div class="flex justify-end">
                                @if($disabled)
                                    <flux:select placeholder="Select action" class="min-w-[9rem]" disabled
                                                 wire:change="changeStatus('{{ $post->id }}', $event.target.value)">
                                        @foreach($options as $val => $label)
                                            <flux:select.option value="{{ $val }}">{{ $label }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                @else
                                    <flux:select placeholder="Select action" class="min-w-[9rem]"
                                                 wire:change="changeStatus('{{ $post->id }}', $event.target.value)">
                                        @foreach($options as $val => $label)
                                            <flux:select.option value="{{ $val }}">{{ $label }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                <tr>
                        <td colspan="9" class="p-6 text-center text-zinc-500">No data available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-outline dark:border-outline-dark">
            {{ $posts->links() }}
        </div>
    </div>
</div>
