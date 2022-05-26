@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Model</th>
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
                                    <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                                    <td>{{ $audit->event }}</td>
                                    <td>{{ $audit->user->name }}</td>
                                    <td>{{ $audit->created_at }}</td>
                                    <td>
                                        @foreach($audit->old_values as $attribute => $value)
                                            {{ $attribute }}
                                            {{ $value }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($audit->new_values as $attribute => $value)
                                            {{ $attribute }}
                                            {{$value}}
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
