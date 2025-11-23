@php
    $postsSeries = $metric?->monthly_series ?? [];
    $userSeries = $metric?->monthly_user_series ?? [];
    $topLiked = $metric?->top_liked_posts ?? [];
    $lastMonthKey = now()->subMonth()->format('Y-m');
    $postsLastMonth = collect($postsSeries)->firstWhere('month', $lastMonthKey)['count'] ?? 0;
    $totalPostsAll = (int) ($metric->total_posts ?? 0);
    $approvedCountAll = (int) ($metric->approved_count ?? 0);
    $approvalRate = $totalPostsAll > 0 ? round(($approvedCountAll / $totalPostsAll) * 100) : 0;
@endphp
<div class="md:p-8 space-y-8">
    <flux:heading class="text-4xl!">Dashboard</flux:heading>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" wire:ignore>
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
            <flux:heading size="xl" class="mb-4">Posts per Month (last 12 months)</flux:heading>
            <div class="relative h-56 md:h-64">
                <canvas id="postsByMonthChart" class="!h-full"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
            <flux:heading size="xl" class="mb-4">New Users per Month (last 12 months)</flux:heading>
            <div class="relative h-56 md:h-64">
                <canvas id="usersByMonthChart" class="!h-full"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6" wire:poll.10s>
        <x-admin-dashboard.stats-card label="Total Posts" icon="rectangle-stack"
                                      :data="number_shorten($metric->total_posts ?? 0)"/>
        <x-admin-dashboard.stats-card label="Posts This Month" icon="calendar"
                                      :data="number_shorten($metric->posts_this_month ?? 0)"/>
        <x-admin-dashboard.stats-card label="Posts Last Month" icon="calendar-days" variant="info"
                                      :data="number_shorten($postsLastMonth)"/>
        <x-admin-dashboard.stats-card label="Approved" icon="check-badge" icon-size="size-12" variant="success"
                                      :data="number_shorten($metric->approved_count ?? 0)"/>
        <x-admin-dashboard.stats-card label="Rejected" icon="x-circle" variant="danger"
                                      :data="number_shorten($metric->rejected_count ?? 0)"/>
        <x-admin-dashboard.stats-card label="Pending" icon="clock" variant="warning"
                                      :data="number_shorten($metric->pending_count ?? 0)"/>
        <x-admin-dashboard.stats-card label="Deleted Posts" icon="trash" variant="danger"
                                      :data="number_shorten($metric->deleted_posts ?? 0)"/>
        <x-admin-dashboard.stats-card label="Approval Rate" icon="chart-bar" variant="neutral"
                                      :data="($approvalRate).'%'"/>
        <x-admin-dashboard.stats-card label="Active Users (30d)" icon="user-group"
                                      :data="number_shorten($metric->active_users ?? 0)"/>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6">
        <flux:heading size="xl" class="mb-4">Top 10 Most Liked Posts</flux:heading>
        <div class="overflow-x-auto">
            <div
                class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
                <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead
                        class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                    <tr>
                        <th scope="col" class="p-4">#</th>
                        <th scope="col" class="p-4">Job Title</th>
                        <th scope="col" class="p-4">Likes</th>
                        <th scope="col" class="p-4">Author</th>
                        <th scope="col" class="p-4">Address</th>
                        <th scope="col" class="p-4">Status</th>
                        <th scope="col" class="p-4">Major</th>
                        <th scope="col" class="p-4">Created at</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-outline-dark">
                    @forelse($topLiked as $i => $data)
                        <tr class="even:bg-primary/5 dark:even:bg-primary-dark/10 hover:bg-primary/10 dark:hover:bg-primary-dark/20">
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $i+1 }}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="hover:underline cursor-pointer">
                                    {{ $data['title'] }}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $data['likes'] }}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $data['author'] }}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $data['address'] ?? '-' }}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $data['status'] ?? '-'}}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $data['major_name'] ?? '-' }}
                                </flux:modal.trigger>
                            </td>
                            <td class="p-4">
                                <flux:modal.trigger name="top-liked-{{ $data['id'] }}" class="block w-full h-full cursor-pointer">
                                    {{ $data['created_at'] }}
                                </flux:modal.trigger>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-4 text-center text-sm text-neutral-600 dark:text-neutral-300" colspan="8">No data found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($topLiked as $data)
        <flux:modal name="top-liked-{{ $data['id'] }}" class="max-w-[90%] w-full sm:max-w-lg outline-none" :dismissible="false">
            <div class="space-y-3">
                <div>
                    <flux:heading class="text-xl">Internship Details</flux:heading>
                </div>
                <flux:separator/>
                <div>
                    <h1 class="text-base md:text-lg">{{ $data['title'] }}</h1>
                    <flux:text class="text-base md:text-lg">{{ $data['company'] ?? '-' }}</flux:text>
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2 place-items-center">
                            <flux:icon.map-pin variant="solid" class="text-red-500"/>
                            <flux:text>{{ $data['address'] ?? '-' }}</flux:text>
                        </div>
                        <div class="flex items-center space-x-2 place-items-center">
                            <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                            <flux:text>{{ $data['major_name'] ?? '-' }}</flux:text>
                        </div>
                        <div class="flex items-center space-x-2 place-items-center">
                            <flux:icon.phone variant="solid" class="text-green-500"/>
                            @php
                                $phone = $data['contact_phone'] ?? '';
                                $cname = $data['contact_name'] ?? '';
                                $contactLine = trim($phone . ($cname !== '' ? ' (' . $cname . ')' : ''));
                            @endphp
                            <flux:text>{{ $contactLine !== '' ? $contactLine : '-' }}</flux:text>
                        </div>
                        <div class="flex items-center space-x-2 place-items-center">
                            <flux:icon.heart variant="solid" class="text-red-500"/>
                            <flux:text>{{ $data['likes'] }} People like this post</flux:text>
                        </div>
                        <div class="flex items-center space-x-2 place-items-center">
                            <flux:icon.calendar-days variant="solid"/>
                            <flux:text>
                                Until {{ \Carbon\Carbon::parse($data['end_date'] ?? $data['created_at'])->format('l, d M Y') }}
                            </flux:text>
                        </div>
                    </div>
                </div>

                <div class="flex gap-x-4 gap-y-2 flex-wrap">
                    <flux:tooltip content="Approve this post">
                        <flux:button size="sm" variant="primary" icon="check-badge" color="green"
                                     wire:click.stop="approvePost('{{ $data['id'] }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="approvePost"/>
                    </flux:tooltip>
                    <flux:tooltip content="Reject this post">
                        <flux:button size="sm" variant="primary" icon="x-circle" color="red"
                                     wire:click.stop="rejectPost('{{ $data['id'] }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="rejectPost"/>
                    </flux:tooltip>
                    <flux:confirm>
                        <flux:tooltip content="Ban this post">
                            <flux:button size="sm" variant="primary" icon="no-symbol" color="zinc"
                                         wire:click.stop="banPost('{{ $data['id'] }}')"
                                         wire:loading.class="pointer-events-none animate-pulse"
                                         wire:target="banPost"/>
                        </flux:tooltip>
                        <flux:confirm.dialog title="Ban this post?"
                                             description="This will permanently block the post and users cannot revert it. Continue?"/>
                    </flux:confirm>
                </div>

                <div class="space-y-2 [&_div]:space-y-1">
                    <div>
                        <flux:heading size="lg">Job Description</flux:heading>
                        <flux:text>{{ $data['job_description'] ?? '-' }}</flux:text>
                    </div>
                    <div>
                        <flux:heading size="lg">Requirements</flux:heading>
                        <flux:text>{{ $data['requirements'] ?? '-' }}</flux:text>
                    </div>
                    <div>
                        <flux:heading size="lg">Benefits</flux:heading>
                        <flux:text>{{ $data['benefits'] ?? '-' }}</flux:text>
                    </div>
                </div>
            </div>
        </flux:modal>
    @endforeach
</div>

<script data-navigate-once src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script data-navigate-once>
    (function () {
        const posts = @json($postsSeries);
        const users = @json($userSeries);

        function buildLabels(posts, users) {
            const base = (posts && posts.length ? posts : users) || [];
            return base.map(d => d.month);
        }

        function valuesFor(labels, series) {
            return labels.map(m => (series.find(d => d.month === m)?.count) ?? 0);
        }

        const state = window.dashboardCharts || {instances: {}};
        window.dashboardCharts = state;

        function destroyIfAny(id) {
            const inst = state.instances[id];
            if (inst && typeof inst.destroy === 'function') {
                try {
                    inst.destroy();
                } catch (e) {
                }
                state.instances[id] = null;
            }
        }

        function initCharts() {
            if (typeof window.Chart === 'undefined') {
                console.warn('Chart.js not loaded yet, retrying...');
                setTimeout(initCharts, 100);
                return;
            }

            const labels = buildLabels(posts, users);
            const postValues = valuesFor(labels, posts || []);
            const userValues = valuesFor(labels, users || []);

            const postsEl = document.getElementById('postsByMonthChart');
            const usersEl = document.getElementById('usersByMonthChart');

            if (!postsEl && !usersEl) return;

            if (postsEl) {
                destroyIfAny('posts');
                state.instances.posts = new Chart(postsEl, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Posts',
                            data: postValues,
                            backgroundColor: 'rgba(59,130,246,0.3)',
                            borderColor: 'rgb(59,130,246)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {y: {beginAtZero: true, ticks: {precision: 0}}}
                    }
                });
            }

            if (usersEl) {
                destroyIfAny('users');
                state.instances.users = new Chart(usersEl, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Users',
                            data: userValues,
                            tension: 0.35,
                            fill: true,
                            backgroundColor: 'rgba(16,185,129,0.2)',
                            borderColor: 'rgb(16,185,129)',
                            borderWidth: 2,
                            pointRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {y: {beginAtZero: true, ticks: {precision: 0}}}
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCharts, {once: true});
        } else {
            initCharts();
        }

        function reinitAfterNavigation() {
            requestAnimationFrame(() => {
                setTimeout(initCharts, 50);
            });
        }

        window.addEventListener('livewire:navigated', reinitAfterNavigation);
        window.addEventListener('turbo:load', reinitAfterNavigation);
        window.addEventListener('popstate', reinitAfterNavigation);
    })();
</script>

