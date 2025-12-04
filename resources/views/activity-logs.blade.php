<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <br/>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
        <p class="text-gray-700">Logged in as: <strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-gray-700">Role: <strong>{{ auth()->user()->role }}</strong></p>
    </div>

    @if(auth()->user()->role === 'admin')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="activityLogs()" x-init="init()">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">System Activity Logs</h3>

                <table class="min-w-full text-left border">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">User</th>
                        <th class="p-2 border">Action</th>
                        <th class="p-2 border">Subject</th>
                        <th class="p-2 border">Changes</th>
                        <th class="p-2 border">Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    <template x-for="log in logs" :key="log._key">
                        <tr>
                            <td class="p-2 border" x-text="log.user?.name ?? 'System'"></td>
                            <td class="p-2 border" x-text="log.action"></td>
                            <td class="p-2 border" x-text="`${log.subject_type} (${log.subject_id})`"></td>
                            <td class="p-2 border" x-text="log.changes ? JSON.stringify(log.changes) : '-'"></td>
                            <td class="p-2 border" x-text="new Date(log.created_at).toLocaleString()"></td>
                        </tr>
                    </template>

                    <tr x-show="logs.length === 0">
                        <td colspan="5" class="p-4 text-center text-gray-600">
                            No activity logs found.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <script>
        const API_TOKEN = "{{ auth()->user()->currentAccessToken()?->plainTextToken ?? auth()->user()->createToken('api-token')->plainTextToken }}";
    </script>

    <script>
        function activityLogs() {
            return {
                logs: [],

                init() {
                    this.fetchLogs();
                },

                getHeaders() {
                    return {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${API_TOKEN}`
                    };
                },

                async fetchLogs() {
                    try {
                        const res = await fetch('/api/v1/activity-logs', {
                            headers: this.getHeaders()
                        });

                        const data = await res.json();
                        console.log('API response:', data);

                        const logsArray = Array.isArray(data) ? data : data.logs ?? data.data ?? [];

                        this.logs = logsArray.map((log, index) => ({
                            ...log,
                            _key: log.id ? log.id + '-' + index : index
                        }));

                        console.log('Alpine logs:', this.logs);

                    } catch (err) {
                        console.error('Error fetching logs:', err);
                        this.logs = [];
                    }
                }
            }
        }
    </script>
</x-app-layout>
