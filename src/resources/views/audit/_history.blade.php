<table class="table table-centered table-nowrap">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Action</th>
        <th scope="col">User</th>
        <th scope="col">Time</th>
        <th scope="col">Old Values</th>
        <th scope="col">New Values</th>
    </tr>
    </thead>
    <tbody id="audits">
    @foreach($audits as $audit)
        <tr>
            <td>{{ $audit->auditable_id }}</td>
            <td>{{ $audit->event }}</td>
            <td>{{ $audit->user->name }}</td>
            <td>{{ $audit->created_at }}</td>
            <td>
                @foreach($audit->old_values as $attribute => $value)
                    {{ $attribute }}
                    {{ $value }}
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
