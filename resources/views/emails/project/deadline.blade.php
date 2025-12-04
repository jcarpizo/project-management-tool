@component('mail::message')
    # Project Deadline Reminder

    Hello **{{ $owner->name }}**,

    Your project **{{ $project->title }}** is due on **{{ $project->deadline->format('F j, Y') }}**.

    **Progress:** {{ $progress }}%

    @component('mail::button', ['url' => url("/projects/{$project->id}")])
        View Project
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
